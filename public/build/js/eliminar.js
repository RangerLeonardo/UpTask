document.querySelector("#eliminar-proyecto").addEventListener("click",(function(){Swal.fire({title:"Eliminar Proyecto",showCancelButton:!0,confirmButtonText:"Si",cancelButtonText:"No"}).then(t=>{t.isConfirmed&&async function(){try{const t="http://localhost:3000/api/proyecto/eliminarProyecto",o=await fetch(t,{method:"POST"}),e=await o.json();e.resultado&&Swal.fire("Botado",e.mensaje,"success")}catch(t){console.log(t)}}()})}));