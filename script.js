document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const customerName = document.getElementById('customerName').value;
    const customerMobile = document.getElementById('customerMobile').value;
    const printType = document.getElementById('printType').value;
    const fileUpload = document.getElementById('fileUpload').files[0];

    // Validate fields
    if (!customerName || !customerMobile || !fileUpload) {
        alert('Please fill in all fields.');
        return;
    }

    const formData = new FormData();
    formData.append('customerName', customerName);
    formData.append('customerMobile', customerMobile);
    formData.append('printType', printType);
    formData.append('fileUpload', fileUpload);

    // Make AJAX request to upload file
    fetch('upload.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('estimateResult').innerHTML = data;
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
