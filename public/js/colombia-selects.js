


document.addEventListener('DOMContentLoaded', function() {
  const selectDepto = document.getElementById('departamento');
  const selectCiudad = document.getElementById('ciudad');
  if (!selectDepto || !selectCiudad) return;

  fetch('/assets/colombia.json')
    .then(response => response.json())
    .then(data => {
      // Poblar departamentos
      selectDepto.innerHTML = '<option value="">Seleccione un departamento</option>';
      data.forEach(dep => {
        const option = document.createElement('option');
        option.value = dep.departamento;
        option.textContent = dep.departamento;
        // Mantener selección tras validación
        if (selectDepto.dataset.selected && selectDepto.dataset.selected === dep.departamento) {
          option.selected = true;
        }
        selectDepto.appendChild(option);
      });

      // Si hay un departamento seleccionado, poblar municipios
      if (selectDepto.value) {
        poblarMunicipios(data, selectDepto.value);
      }

      selectDepto.addEventListener('change', function () {
        poblarMunicipios(data, this.value);
      });

      function poblarMunicipios(departamentos, departamento) {
        selectCiudad.innerHTML = '<option value="">Seleccione un municipio</option>';
        const dep = departamentos.find(d => d.departamento === departamento);
        if (dep) {
          dep.municipios.forEach(mun => {
            const option = document.createElement('option');
            option.value = mun;
            option.textContent = mun;
            // Mantener selección tras validación
            if (selectCiudad.dataset.selected && selectCiudad.dataset.selected === mun) {
              option.selected = true;
            }
            selectCiudad.appendChild(option);
          });
        }
      }
    })
    .catch(error => {
      console.error('Error cargando departamentos y municipios:', error);
    });
});
