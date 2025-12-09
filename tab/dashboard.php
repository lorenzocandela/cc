<div id="DASHBOARD">
    <div id="BACINELLA"> <!-- sfondo -->
        <div id="first-section"> <!-- btn short per registrazione vendite e prodotti nuovi -->
            <?php include './sezioni/dashboard/first.php'?>
        </div>

        <div id="second-section"> <!-- sezione intera dei prodotti, anzich table mostriamo elenco completo organizzabile per righe o riquadrei (futuro), righe 10 da 4 come defualt se scrolla verso il basso/clicca carica => carica altre 4 righe da 4 -->
            <?php include './sezioni/dashboard/second.php'?>
        </div>

        <div id="load-more-btn">
            <button id="loadmore" class="btn"><img id="carica" src="./img/ico/load.svg"> Carica</button>
        </div>
    </div>

    <div id="INSERIMENTO">
        <img src="./img/ico/add.svg" alt="Add">
        <form id="form-inserimento">
            <div class="group">
                <div class="form-group">
                    <label for="product-name">Nome</label>
                    <input type="text" id="product-name" name="product-name" placeholder="es. Slip, Reggiseno, etc...">

                    <label for="product-code">Codice</label>
                    <input type="text" id="product-code" name="product-code" placeholder="es. P0CDC7">

                    <label for="product-model">Modello</label>
                    <input type="text" id="product-model" name="product-model" placeholder="es. No Ferretto, Brasiliana, etc...">

                    <label for="product-type">Tipo</label>
                    <input type="text" id="product-type" name="product-type" placeholder="es. Cotone, Pizzo, etc...">

                    <label for="product-size">Taglia</label>
                    <input type="text" id="product-size" name="product-size" placeholder="es. S, M, L, etc...">

                    <label for="product-color">Colore</label>
                    <input type="text" id="product-color" name="product-color" placeholder="es. Nero, Nudo, Beige, etc...">
                </div>
                <div class="form-group">
                    <label for="product-brand">Marca</label>
                    <input type="text" id="product-brand" name="product-brand" placeholder="es. Lovable, PlayTex, etc...">

                    <label for="product-category">Categoria</label>
                    <select id="product-category" name="product-category">
                        <option value="intimo-donna">Intimo Donna</option>
                        <option value="intimo-uomo">Intimo Uomo</option>
                        <option value="intimo-bimbo">Intimo Bimbo</option>
                        <option value="intimo-bimba">Intimo Bimba</option>
                        <option value="abbigliamento-donna">Abbigliamento Donna</option>
                        <option value="abbigliamento-uomo">Abbigliamento Uomo</option>
                        <option value="abbigliamento-bimbo">Abbigliamento Bimbo</option>
                        <option value="abbigliamento-bimba">Abbigliamento Bimba</option>
                        <option value="calzetteria">Calzetteria</option>
                        <option value="casa">Casa</option>
                    </select>

                    <label for="product-quantity">Quantità</label>
                    <input type="number" id="product-quantity" name="product-quantity" placeholder="1, 7, 10 ...">

                    <label for="product-serial">Seriale</label>
                    <input type="text" id="product-serial" name="product-serial" placeholder="Scanner o manualmente">

                    <label for="product-price">Prezzo</label>
                    <input type="number" step="0.01" id="product-price" name="product-price" placeholder="es. 15,99" style="margin-bottom: 30px;">
                </div>
            </div>
            <button type="submit" name="CREA">AGGIUNGI</button>
        </form>
    </div>

    <div id="REGISTRO">
        <img src="./img/ico/sold.svg" alt="Sold">
        <form id="form-registro">
            <div class="group">
                <div class="form-group">
                    <label for="sales-serial">Seriale</label>
                    <input type="text" id="sales-serial" name="sales-serial">
                    <label for="sales-qty">Quantità</label>
                    <input type="number" id="sales-qty" name="sales-qty">
                </div>
            </div>
            <button type="submit" name="REGISTRA">REGISTRA</button>
        </form>
    </div>
</div>