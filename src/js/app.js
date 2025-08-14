let paso=1;
const pasoInicial=1;
const pasoFinal=3;
cita= {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}


document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});

function iniciarApp(){
    mostrarSeccion();
    tabs();
    botonesPaginador();
    paginaAnterior();
    paginaSiguiente();

    consultarAPI();

    nombreCliente();
    idCliente();
    seleccionarFecha();
    seleccionarHora();
    mostrarResumen();
}

function mostrarSeccion(){
    const seccionAnterior = document.querySelector('.mostrar');
    if(seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }

    const pasoActual=document.querySelector(`#paso-${paso}`);
    pasoActual.classList.add('mostrar');

    const tabAnterior= document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }

    const tabActual= document.querySelector(`[data-paso="${paso}"]`);
    tabActual.classList.add('actual');
}




function tabs(){
    const botones= document.querySelectorAll('.tabs button');
    botones.forEach(boton => {
        boton.addEventListener('click', function(e){
            e.preventDefault();
            paso= parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();
        })
    });
}

function botonesPaginador(){
    const paginaAnterior= document.querySelector('#anterior');
    const paginaSiguiente= document.querySelector('#siguiente');

    if(paso===1){
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }else if(paso===3){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    }else{
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

function paginaAnterior(){
    const paginaAnterior= document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function(){
        if(paso<=pasoInicial) return;
        paso--;
        botonesPaginador();
    })
}

function paginaSiguiente(){
    const paginaSiguiente= document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function(){
        if(paso>=pasoFinal) return;
        paso++;
        botonesPaginador();
    })
}

async function consultarAPI(){
    try {
        const url= '/api/servicios';
        const resultado= await fetch(url);
        const servicios= await resultado.json();
        mostrarServicios(servicios);

    } catch (error) {
        console.log(error);
    }
}


function mostrarServicios(servicios){
    servicios.forEach(servicio => {
        const {id, nombre, precio} = servicio;

        const nombreServicio= document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent= nombre;

        const precioServicio= document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent= `$${precio}`;

        const divServicio= document.createElement('DIV');
        divServicio.classList.add('servicio');
        divServicio.dataset.idServicio= id;
        divServicio.onclick= function(){
            seleccionarServicio(servicio);
        }

        divServicio.appendChild(nombreServicio);
        divServicio.appendChild(precioServicio);
        document.querySelector('#servicios').appendChild(divServicio);
    });
}

function seleccionarServicio(servicio){
    const {id}= servicio;
    const {servicios} = cita;
    
    const divServicio= document.querySelector(`[data-id-servicio="${id}"]`);

    if( servicios.some( agregado=> agregado.id === id)){
        cita.servicios= servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove("seleccionado");
    }else{
        cita.servicios= [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }
}

function idCliente(){
    cita.id= document.querySelector('#id').value;
}

function nombreCliente(){
    cita.nombre= document.querySelector('#nombre').value;
}

function seleccionarFecha(){
    const inputDate= document.querySelector('#fecha');

    inputDate.addEventListener('change', function(e){
        const dia= new Date(e.target.value).getUTCDay();
        if([0, 6].includes(dia)){
            e.target.value='';
            mostrarAlerta('Seleccione un día de lunes a viernes', 'error', '.formulario');
        }else{
            cita.fecha= e.target.value;
        }
    })
}

function seleccionarHora(){
    const inputHora= document.querySelector('#hora');

    inputHora.addEventListener('change', function(e){
        const horaCita= e.target.value;
        const hora= horaCita.split(":")[0];
        if(hora<10 || hora>18){
            e.target.value= '';
            mostrarAlerta('Seleccione un horario entre las 10 y las 18', 'error', '.formulario');
        }else{
            cita.hora= e.target.value;
        }
    }
    )
}

function mostrarAlerta(mensaje, tipo, elemento, desaparece=true){
    alertaPrevia= document.querySelector('.alerta');
    if(alertaPrevia){
        alertaPrevia.remove();
    }

    const alerta= document.createElement('DIV');
    alerta.textContent= mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);
    const referencia= document.querySelector(elemento);
    referencia.appendChild(alerta);

    if(desaparece){
        setTimeout(()=>{
            alerta.remove();
        }, 3000);
    }
}


function mostrarResumen() {
    const resumen=document.querySelector('.contenido-resumen');
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }

    if(Object.values(cita).includes('') || cita.servicios.length === 0 ) {
        mostrarAlerta('Faltan datos de Servicios, Fecha u Hora', 'error', '.contenido-resumen', false);

        return;
    } 
    
    const {id, nombre, fecha, hora, servicios}= cita;
    tituloResumen= document.createElement('H3');
    tituloResumen.classList.add('titulo-resumen');
    tituloResumen.textContent= 'Resumen Servicios';
    resumen.appendChild(tituloResumen);

    servicios.forEach(servicio=>{
        const {id, nombre, precio}= servicio;
        const divServicio=document.createElement('DIV');
        divServicio.classList.add('servicio-resumen');

        tituloServicio= document.createElement('P');
        tituloServicio.classList.add('titulo-servicio-resumen');
        tituloServicio.textContent= nombre;

        precioServicio= document.createElement('P');
        precioServicio.classList.add('precio-servicio-resumen');
        precioServicio.innerHTML= `<span>Precio:</span> $${precio}`;

        divServicio.appendChild(tituloServicio);
        divServicio.appendChild(precioServicio);
        resumen.appendChild(divServicio);
    })

    tituloResumen= document.createElement('H3');
    tituloResumen.classList.add('titulo-resumen');
    tituloResumen.textContent= 'Resumen Cita';
    resumen.appendChild(tituloResumen);

    const resumenCita= document.createElement('DIV');
    resumenCita.classList.add('cita-resumen');
    nombreCita= document.createElement('P');
    nombreCita.classList.add('titulo-servicio-resumen');
    nombreCita.innerHTML= `<span>Nombre: </span> ${nombre}`;

    const fechaObj= new Date(fecha);
    const mes= fechaObj.getMonth();
    const dia= fechaObj.getDate() +2;
    const año= fechaObj.getFullYear();

    const fechaUTC= new Date(Date.UTC(año, mes, dia));
    const opciones= {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'};
    const fechaFormateada= fechaUTC.toLocaleDateString('es-MX', opciones);

    fechaCita= document.createElement('P');
    fechaCita.classList.add('precio-servicio-resumen');
    fechaCita.innerHTML= `<span>Fecha: </span> ${fechaFormateada}`;

    horaCita= document.createElement('P');
    horaCita.classList.add('precio-servicio-resumen');
    horaCita.innerHTML= `<span>Hora: </span> ${hora}`;

    const divBoton= document.createElement('DIV');
    divBoton.classList.add('div-boton');
    const botonReservar= document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent= 'Reservar Cita';
    botonReservar.onclick= reservarCita;
    divBoton.appendChild(botonReservar);

    resumenCita.appendChild(nombreCita);
    resumenCita.appendChild(fechaCita);
    resumenCita.appendChild(horaCita);
    resumenCita.appendChild(divBoton);
    resumen.appendChild(resumenCita);
}

async function reservarCita(){
    const {nombre, fecha, hora, servicios, id}= cita;
    const idServicios= servicios.map(servicio=>servicio.id);
    const datos= new FormData();

    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioId', id);
    datos.append('servicios', idServicios);

    try {
        const url= '/api/citas';
        const respuesta= await fetch(url, {
            method: 'POST',
            body: datos
        })

        const resultado= await respuesta.json();
        if(resultado.resultado){
            Swal.fire({
                title: "Cita Reservada",
                text: "Su cita se ha reservado correctamente",
                icon: "success",
            });
            setTimeout(() => {
                window.location.reload();
            }, 3000);   
        }
    } catch (error) {
        Swal.fire({
            title: "Error",
            text: "Hubo un error al reservar la cita",
            icon: "error",
            });
    }

}