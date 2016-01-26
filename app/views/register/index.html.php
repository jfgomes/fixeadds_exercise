<?php include_once APP_PATH . "/views/layouts/header.html.php"; ?>
<h1>Registe-se gratuitamente</h1>
<h2>Registe-se de forma f&aacute;cil e r&aacute;pida. O registo &eacute; f&aacute;cil e gr&aacute;tis.</h2>
<div class="form_div">
    <form id="form" name="form" method="POST" action="/index.php?controller=register&action=create">
        <section>
            <p>
                <label for="email">
                    <span class="form_span">Email *</span> 
                    <input type="text" id="email" class="form_input" name="user[email]" 
                           value="<?php echo isset($params['user']) ? $params['user']['email'] : "" ?>" required />                    
                </label>            
            </p>
            <div class="clearfix"></div>
            <p>
                <label for="confirm_email">
                    <span class="form_span">Confirmar Email *</span>       
                    <input type="text" id="confirm_email" class="form_input" name="user[confirm_email]" 
                           value="<?php echo isset($params['user']) ? $params['user']['confirm_email'] : "" ?>" required />
                </label>
            </p>
            <div class="clearfix"></div>
            <p>
                <label for="email">
                    <span class="form_span">Password *</span>
                    <input type="password" id="password" name="user[password]" class="form_input form_input_short" required />               
                </label>
            <div class="clearfix"></div>
            <label for="confirm_email">
                <span class="form_span margin_top">Confirmar Password *</span>                  
                <input type="password" id="confirm_password" name="user[confirm_password]" class="form_input form_input_short margin_top" required />
                
                <span id="pass_strong_span" class="form_span">A sua password é segura?</span> 
                <input id="pass_strong" readonly="readonly" />
            </label>

            </p>
            <div class="clearfix"></div>
            <p>
                <label for="first_name">
                    <span class="form_span">Primeiro Nome *</span>
                    <input type="text" id="first_name" class="form_input form_input_short" name="user[first_name]" 
                           value="<?php echo isset($params['user']) ? $params['user']['first_name'] : "" ?>" placeholder=" Nome" required />               
                </label>
                
                <label for="last_name">
                    <span class="form_span"></span>
                    <input type="text" id="last_name" class="form_input form_input_short" name="user[last_name]"
                           value="<?php echo isset($params['user']) ? $params['user']['last_name'] : "" ?>" placeholder=" Apelido" required />
                </label>
            </p> 
            <div class="clearfix"></div>
            <p>
                <label for="address">
                    <span class="form_span">Rua / Nº</span>
                    <input type="text" id="address" class="form_input" name="user[address]" 
                           value="<?php echo isset($params['user']) ? $params['user']['address'] : "" ?>" />
                </label>
            </p>
            <div class="clearfix"></div>
            <p>
                <label for="zipcode">
                    <span class="form_span">Código Postal / Localidade</span>
                    <input type="text" id="zipcode" class="form_input form_input_short" name="user[zipcode]"
                           value="<?php echo isset($params['user']) ? $params['user']['zipcode'] : "" ?>" placeholder=" Ex. 9999-999" />               
                </label>
                <label for="zone">
                    <span class="form_span"></span>
                    <input type="text" id="zone" class="form_input form_input_short" name="user[zone]" 
                           value="<?php echo isset($params['user']) ? $params['user']['zone'] : "" ?>" />
                </label>
            </p>
            <div class="clearfix"></div>
            <p>
                <label for="country">
                    <span class="form_span">País</span>
                    <select id="country" class="form_select" name="user[country]">
                        <option value="PT">Portugal</option>
                        <option value="BR">Brasil</option>
                        <option value="ES">Espanha</option>
                        <option value="FR">Fran&ccedil;a</option>
                    </select>
                </label>
            </p>
            <div class="clearfix"></div>
            <p>
                <label for="vat">
                    <span class="form_span">NIF</span>
                    <input type="text" id="vat" class="form_input" name="user[vat]" 
                           value="<?php echo isset($params['user']) ? $params['user']['vat'] : "" ?>" />
                </label>
            </p>
            <div class="clearfix"></div>
            <p>
                <label for="phone">
                    <span class="form_span">Telefone</span>
                    <input type="text" id="phone" class="form_input" name="user[phone]" 
                           value="<?php echo isset($params['user']) ? $params['user']['phone'] : "" ?>" placeholder=" Insira o n&uacute;mero aqui" />
                </label>
            </p>
            <div class="clearfix"></div>
            <p>
                <span class="form_span">&nbsp;</span>
                <button id="submit_btn" class="form_btn" type="button">Registo</button>
            </p>
            <div class="clearfix"></div>
        </section>
    </form>
</div>
<?php include_once APP_PATH . "/views/layouts/footer.html.php"; ?>
