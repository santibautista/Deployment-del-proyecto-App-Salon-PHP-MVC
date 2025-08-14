document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});

function iniciarApp(){
    buscarPorFecha();
}

function buscarPorFecha(){
    const inputFecha= document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e){
        const fechaSeleccionada= e.target.value;
        window.location= `?fecha=${fechaSeleccionada}`
    })
}
