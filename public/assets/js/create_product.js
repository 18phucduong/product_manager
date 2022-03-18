window.addEventListener('DOMContentLoaded', (event) => {
    // Preview image in create product
      let inputPreview = document.getElementById('preview-input');
  
      inputPreview.addEventListener('change', (event) => {
        let output = document.getElementById('preview-output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.className = "show mb-1";
        output.onload = function() {
          URL.revokeObjectURL(output.src)
        }
      });
});