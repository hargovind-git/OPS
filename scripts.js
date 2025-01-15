document.addEventListener("DOMContentLoaded", function () {
    const estimateBtn = document.getElementById('estimateBtn');

    estimateBtn.addEventListener('click', async function () {
        const fileUpload = document.getElementById('fileUpload').files[0];
        const printType = document.getElementById('printType').value;
        const customerName = document.getElementById('customerName').value;
        const customerMobile = document.getElementById('customerMobile').value;

        // Validation: Ensure all inputs are filled
        if (!fileUpload) {
            alert("Please upload a file!");
            return;
        }
        if (!customerName.trim()) {
            alert("Please enter your name!");
            return;
        }
        if (!customerMobile.trim() || !/^\d{10,15}$/.test(customerMobile)) {
            alert("Please enter a valid mobile number (10-15 digits)!");
            return;
        }

        // File type validation
        const validTypes = ["application/pdf", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "image/jpeg", "image/png"];
        if (!validTypes.includes(fileUpload.type)) {
            alert("Unsupported file type. Please upload a PDF, Word, or image file.");
            return;
        }

        // Page count determination
        let pageCount = 0;

        if (fileUpload.type === "application/pdf") {
            // Extract page count for PDFs using PDF.js
            pageCount = await getPdfPageCount(fileUpload);
        } else if (fileUpload.type === "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
            // Placeholder: DOCX page count estimation (requires server-side implementation for accurate count)
            pageCount = 10; // Assuming 10 pages for now
        } else if (fileUpload.type.startsWith("image/")) {
            // Each image is treated as one page
            pageCount = 1;
        }

        if (pageCount === 0) {
            alert("Failed to determine page count. Please try again with a supported file.");
            return;
        }

        // Calculate estimated cost
        const costPerPage = (printType === 'bw') ? 3 : 5; // B/W = 3 INR, Color = 5 INR
        const estimatedCost = pageCount * costPerPage;

        // Display the results in the feedback section
        const resultDiv = document.getElementById('estimateResult');
        resultDiv.innerHTML = `
            <p><strong>Number of Pages:</strong> ${pageCount}</p>
            <p><strong>Print Type:</strong> ${printType === 'bw' ? 'Black & White' : 'Color'}</p>
            <p><strong>Estimated Price:</strong> <span>${estimatedCost} INR</span></p>
        `;
    });

    /**
     * Get the page count of a PDF file using PDF.js.
     * @param {File} pdfFile - The PDF file.
     * @returns {Promise<number>} - The number of pages in the PDF.
     */
    async function getPdfPageCount(pdfFile) {
        const fileReader = new FileReader();
        return new Promise((resolve, reject) => {
            fileReader.onload = async function () {
                const pdfData = new Uint8Array(fileReader.result);
                try {
                    const pdf = await pdfjsLib.getDocument({ data: pdfData }).promise;
                    resolve(pdf.numPages);
                } catch (error) {
                    reject(error);
                }
            };
            fileReader.onerror = function () {
                reject(fileReader.error);
            };
            fileReader.readAsArrayBuffer(pdfFile);
        });
    }
});
