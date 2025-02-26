
<div class="modal-background order-modal">

    <div class="modal-container">

        <div class="close-modal" title="Cerrar">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg>
        </div>

        <h2>Pedido en curso 📋</h2>

        <?php if(empty($sucursales)): ?>

            <h2>
                ¡Debes agregar al menos una sucursal para realizar y enviar pedidos!
                <animated-icons
                    src="https://animatedicons.co/get-icon?name=search&style=minimalistic&token=12e9ffab-e7da-417f-a9d9-d7f67b64d808"
                    trigger="loop"
                    attributes='{"variationThumbColour":"#536DFE","variationName":"Two Tone","variationNumber":2,"numberOfGroups":2,"backgroundIsGroup":false,"strokeWidth":1,"defaultColours":{"group-1":"#000000","group-2":"#536DFE","background":"#FFFFFF"}}'
                    height="200"
                    width="200"
                >
                </animated-icons>
            </h2>

        <?php else: ?>
            <div class="content-modal">
                <form action="" autocomplete="off" method="POST">
                    <div class="header-send-order">
                        <div class="order-summary">
                            <p>Total de productos:</p>
                            <span class="total-products-order-count"></span>
                        </div>

                        <button type="button" id="send-order-btn">
                            Envíar pedido
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M280-160q-50 0-85-35t-35-85H60l18-80h113q17-19 40-29.5t49-10.5q26 0 49 10.5t40 29.5h167l84-360H182l4-17q6-28 27.5-45.5T264-800h456l-37 160h117l120 160-40 200h-80q0 50-35 85t-85 35q-50 0-85-35t-35-85H400q0 50-35 85t-85 35Zm357-280h193l4-21-74-99h-95l-28 120Zm-19-273 2-7-84 360 2-7 34-146 46-200ZM20-427l20-80h220l-20 80H20Zm80-146 20-80h260l-20 80H100Zm180 333q17 0 28.5-11.5T320-280q0-17-11.5-28.5T280-320q-17 0-28.5 11.5T240-280q0 17 11.5 28.5T280-240Zm400 0q17 0 28.5-11.5T720-280q0-17-11.5-28.5T680-320q-17 0-28.5 11.5T640-280q0 17 11.5 28.5T680-240Z"/></svg>
                        </button>
                    </div>

                    <div class="select-destination-branch-container">
                        <select name="destination-branch" id="select-destination-branch" class="crud-header-select select-destination-branch">
                            <option disabled selected>Selecciona la sucursal de destino</option>
                            <?php foreach($sucursales as $sucursal): ?>
                                <option value="<?=ucwords($sucursal['nombre_sucursal'])?>" data-branch-id="<?=encryptValue($sucursal['id_sucursal'], SECRETKEY)?>">
                                    <?=ucwords($sucursal['nombre_sucursal'])?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <div class="order-value">
                            <p>
                                Valor del pedido:
                            </p>
                            <span>
                                <span
                                    class="bg-gray-300 border-[1px] flex items-center justify-center border-gray-400 border-solid shadow-lg text-center w-[24px] h-[24px] rounded-full"
                                    title="La Suma de los Precios de Venta de los productos añadidos representa el Valor del Pedido"
                                >
                                    <span class="bg-white text-center rounded-full p-0.5 text-[.7rem] w-[15px] flex items-center justify-center h-[15px]">❓</span>
                                </span>
                                $
                                <span id="order-price-value">
                                </span>
                                .°°
                            </span>
                        </div>
                    </div>

                    <div class="grid-list" id="grid-list">

                        <!-- SE INSERTAN LOS PRODUCTOS AÑADIDOS CON JQUERY -->

                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>
