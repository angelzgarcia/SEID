


// <--!     C A L E N D A R I O   F A L T P I C K R       !-->
flatpickr("#datepicker", {
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "F j, Y",
    locale: "es",
});


document.addEventListener('DOMContentLoaded', () => {
    // P R E V E N I R   Q U E   E L   C O D I G O   D E   B A R R A S   E N V I E   E L   F O R M U L A R I O
    let inputCodigoBarras = document.querySelector("input[name='codigo_barras']");
    inputCodigoBarras.addEventListener("keydown", function(event) {
        if (event.key === "Enter")
            event.preventDefault();
    });


    // <!-- M O S T R A R   C A M P O S   P A R A   M A Y O R E O -->
    const radios = document.querySelectorAll('input[name="aplica_mayoreo"]');
    const minQuantityWholesale = document.getElementById('min-quantity-wholesale');
    const wholesalePrice = document.getElementById('wholesale-price');

    function toggleWholesaleFields() {
        const selected = document.querySelector('input[name="aplica_mayoreo"]:checked');

        if (selected && selected.value === '0') {
            minQuantityWholesale.style.display = 'flex';
            wholesalePrice.style.display = 'flex';
        } else {
            minQuantityWholesale.style.display = 'none';
            wholesalePrice.style.display = 'none';
        }
    }

    toggleWholesaleFields();

    radios.forEach(radio => {
        radio.addEventListener('change', toggleWholesaleFields);
    });


    //<!-- F A C T O R   D E   C O N V E R S I O N -->
    const unidadCompra = document.getElementById("unidad_compra");
    const unidadVenta = document.getElementById("unidad_venta");
    const conversionExtra = document.getElementById("conversion_extra");
    const cantidadConversion = document.getElementById("cantidad_conversion");
    const factorConversion = document.getElementById("factor_conversion");
    const conversionResult = document.getElementById("conversion_result");
    const stockLabel = document.getElementById("stockLabel");

    const unidadesConversión = ["paquete", "caja"];

    unidadCompra.addEventListener("change", function() {
        let selectedCompra = unidadCompra.value;
        let selectedVenta = unidadVenta.value;

        if (unidadesConversión.includes(selectedCompra) && selectedCompra !== selectedVenta) {
            conversionExtra.style.display = "block";
        } else {
            conversionExtra.style.display = "none";
            cantidadConversion.value = 1;
            factorConversion.value = 1;
            conversionResult.textContent = "";
        }

        stockLabel.textContent = `Cantidad de ${selectedCompra}s en stock`;
    });

    unidadVenta.addEventListener("change", function() {
        unidadCompra.dispatchEvent(new Event("change"));
    });


    unidadVenta.addEventListener("change", calcularFactorConversion);
    cantidadConversion.addEventListener("input", calcularFactorConversion);

    function calcularFactorConversion() {
        let selectedCompra = unidadCompra.value;
        let selectedVenta = unidadVenta.value;
        let cantidad = cantidadConversion.value;

        if (!cantidad || cantidad <= 0) {
            factorConversion.value = "";
            conversionResult.textContent = "";
            return;
        }

        let factor = 1;

        if (selectedCompra === "bulto" && selectedVenta === "kg") {
            factor = cantidad;
        } else if (selectedCompra === "bulto" && selectedVenta === "gramo") {
            factor = cantidad * 1000;
        } else if (selectedCompra === "rollo" && selectedVenta === "metro") {
            factor = cantidad;
        } else if (selectedCompra === "rollo" && selectedVenta === "centimetro") {
            factor = cantidad * 100;
        } else if (selectedCompra === "saco" && selectedVenta === "kg") {
            factor = cantidad;
        } else if (selectedCompra === "saco" && selectedVenta === "gramo") {
            factor = cantidad * 1000;
        } else if (selectedCompra === "paquete" && selectedVenta === "pieza") {
            factor = cantidad;
        } else if (selectedCompra === "caja" && selectedVenta === "pieza") {
            factor = cantidad;
        } else if (selectedCompra === "pieza" && selectedVenta === "pieza") {
            factor = 1;
        }

        factorConversion.value = factor;
        conversionResult.textContent = `1 ${selectedCompra} = ${factor} ${selectedVenta}s`;
    }

});


function validarCodigoBarras(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
}


function validarUnidades(input) {
    input.value = input.value.replace(/^0+|[^0-9]/g, '');
}


function validarPrecios(input) {
    input.value = input.value.replace(/^0+(\d)/, '$1')
                            .replace(/[^0-9.]/g, '')
                            .replace(/(\..*)\./g, '$1')
                            .replace(/^(\d+\.\d{2})\d+$/, '$1');

    if (input.value === "0") input.value = "";

    if (input.value.startsWith('.')) input.value = '';
}


// <!-- V I S T A   P R E V I A   D E   L A   I M A G E N -->
function mostrarVistaPrevia(event) {
    const fileInput = event.target;
    const file = fileInput.files[0];
    const previewImg = document.getElementById("previewImg");
    const uploadText = document.getElementById("uploadText");

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewImg.style.display = "block";
            uploadText.style.display = "none";
        };
        reader.readAsDataURL(file);
    }
}
