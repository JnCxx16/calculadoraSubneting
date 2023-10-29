document.getElementById('calculadoraForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    var ip = document.getElementById('ip').value;
    var mascara = document.getElementById('mascara').value;

   
    var resultadoDiv = document.getElementById('resultado');
    resultadoDiv.innerHTML = "<?php echo calcularSubred('"+ip+"', "+mascara+"); ?>";
});