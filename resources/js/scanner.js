import QrScanner from 'qr-scanner';

const video = document.getElementById('qr-video');
const camQrResult = document.getElementById('cam-qr-result');
const fileSelector = document.getElementById('file-selector');
const fileQrResult = document.getElementById('file-qr-result');

const scanner = new QrScanner(
    video,
    result => setResult(camQrResult, result), {
        onDecodeError: error => {
            camQrResult.textContent = error;
            camQrResult.style.color = 'inherit';
        },
        highlightScanRegion: true,
        highlightCodeOutline: true,
    }
);

function setResult(label, result) {
    label.textContent = result.data;
    label.style.color = 'teal';
    clearTimeout(label.highlightTimeout);
    label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);

    scanner.stop();
}

QrScanner.hasCamera().then(function(hasCamera) {
    if (hasCamera) {
        document.getElementById('start-button').addEventListener('click', () => {
            scanner.setInversionMode('both');
            scanner.start();
        });
    }
});

fileSelector.addEventListener('change', event => {
    const file = fileSelector.files[0];
    if (!file) {
        return;
    }

    QrScanner.scanImage(file, { returnDetailedScanResult: true })
        .then(result => setResult(fileQrResult, result))
        .catch(e => setResult(fileQrResult, {
            data: e || 'No QR code found.'
        }));
});