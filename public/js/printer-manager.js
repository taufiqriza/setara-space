if (!window.PrinterManager) { // Prevent redeclaration error
    window.PrinterManager = class PrinterManager {
        constructor() {
            this.device = null;
            this.characteristic = null;
            this.isConnected = false;
            // Standard Bluetooth standard service UUIDs for printers
            this.serviceUuid = '000018f0-0000-1000-8000-00805f9b34fb';
            this.writeCharacteristicUuid = '00002af1-0000-1000-8000-00805f9b34fb';
        }

        async connect() {
            // 1. Cek apakah Browser Support Web Bluetooth
            if (!navigator.bluetooth) {
                this.handleError('Web Bluetooth API is not supported in this browser. Please use Chrome or Edge.');
                return false;
            }

            // 2. Cek apakah Adapter Bluetooth Aktif (Hardware)
            try {
                const isAvailable = await navigator.bluetooth.getAvailability();
                if (!isAvailable) {
                    this.handleError('Bluetooth adapter not found or disabled. Please turn on Bluetooth on your device.');
                    return false;
                }
            } catch (e) {
                console.warn('Bluetooth availability check failed, proceeding anyway...', e);
            }

            try {
                console.log('Requesting Bluetooth Device...');
                this.device = await navigator.bluetooth.requestDevice({
                    acceptAllDevices: true,
                    optionalServices: [this.serviceUuid, this.writeCharacteristicUuid]
                });

                this.device.addEventListener('gattserverdisconnected', this.onDisconnected.bind(this));

                console.log('Connecting to GATT Server...');
                const server = await this.device.gatt.connect();

                console.log('Getting Service...');
                const service = await server.getPrimaryService(this.serviceUuid);

                console.log('Getting Characteristic...');
                this.characteristic = await service.getCharacteristic(this.writeCharacteristicUuid);

                this.isConnected = true;
                console.log('Printer Connected!');

                window.dispatchEvent(new CustomEvent('printer-connected', { detail: { name: this.device.name } }));

                return true;
            } catch (error) {
                console.error('Connection Error:', error);

                let msg = error.message;
                if (error.name === 'NotFoundError') {
                    msg = 'No device selected or Bluetooth adapter missing.';
                } else if (error.name === 'SecurityError') {
                    msg = 'Security check failed. Ensure you represent HTTPS or localhost.';
                }

                this.handleError(msg);
                this.isConnected = false;
                return false;
            }
        }

        handleError(msg) {
            window.dispatchEvent(new CustomEvent('printer-error', { detail: { message: msg } }));
        }

        onDisconnected(event) {
            console.log('Device disconnected');
            this.isConnected = false;
            window.dispatchEvent(new CustomEvent('printer-disconnected'));
        }

        async printTest() {
            if (!this.isConnected) {
                alert('Printer not connected');
                return;
            }

            const commands = [
                this.ESC.INIT,
                this.ESC.ALIGN_CENTER,
                this.ESC.BOLD_ON,
                this.text("SETARA SPACE\n"),
                this.ESC.BOLD_OFF,
                this.text("Test Print Success!\n"),
                this.text("--------------------------------\n"),
                this.ESC.ALIGN_LEFT,
                this.text("Printer is ready to serve.\n\n\n\n"),
                this.ESC.CUT_PAPER
            ];

            await this.sendCommands(commands);
        }

        async sendCommands(commands) {
            if (!this.characteristic) return;

            const buffer = new Uint8Array(commands.reduce((acc, cmd) => {
                return acc.concat(Array.from(cmd));
            }, []));

            const chunkSize = 100;
            for (let i = 0; i < buffer.byteLength; i += chunkSize) {
                const chunk = buffer.slice(i, i + chunkSize);
                await this.characteristic.writeValue(chunk);
            }
        }

        text(str) {
            const encoder = new TextEncoder('utf-8');
            return encoder.encode(str);
        }

        get ESC() {
            return {
                INIT: new Uint8Array([0x1B, 0x40]),
                ALIGN_LEFT: new Uint8Array([0x1B, 0x61, 0x00]),
                ALIGN_CENTER: new Uint8Array([0x1B, 0x61, 0x01]),
                ALIGN_RIGHT: new Uint8Array([0x1B, 0x61, 0x02]),
                BOLD_ON: new Uint8Array([0x1B, 0x45, 0x01]),
                BOLD_OFF: new Uint8Array([0x1B, 0x45, 0x00]),
                CUT_PAPER: new Uint8Array([0x1D, 0x56, 0x00]),
                FEED_LINES: (n) => new Uint8Array([0x1B, 0x64, n])
            };
        }
    }
}

// Global Instance Check
if (!window.printerManager) {
    window.printerManager = new window.PrinterManager();
}
