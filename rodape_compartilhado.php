<!-- <head>
    <link rel="stylesheet" href="rodape_compartilhado_estilo.css">
</head> -->

<footer class="border-top footer text-muted">
    <div class="Text-center">
        <div class="container-fluid">
            <p>SisSASS | Serviço de Atendimento à Saúde do Servidor</p>
            <p>&copy; <?php echo date("Y"); ?> GETIN | HEMOPA </p>
            <!-- @* &copy; 2025 - SisSASS___ASP_NET_MVC_5 - <a asp-area="" asp-controller="Home" asp-action="Privacy">Privacy</a> *@ -->
        </div>
    </div>
</footer>

<style>
    /* -------------- Rodapé -------------- */

    footer {
        /*position: absolute;*/
        position: fixed;
        padding-top: 0px;
        /* Altera na altura da borda superior */
        padding-bottom: 0px;
        bottom: 0;
        width: 100%;
        z-index: 1000;
        text-align: center;
        margin: 0px !important;
        /* Remove margens adicionais */
        /*background-color: white;*/
        /* Cor branca evita que o cabeçalho fique transparente */
        background-color: #1E3A5F;
        /*background-color: #F1C232;*/
        /*Cor: Gold*/
        /*#F7E14A;*/
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        height: 45px;
        /* Define uma altura fixa para o cabeçalho */
    }

    footer p {
        margin: 0px !important;
        padding-top: 3px;
        /* Altera na altura da borda superior */
        padding-bottom: 1px;
        line-height: 0.9 !important;
        /* Ajusta o espaçamento entre linhas */
        font-size: 14px;
        color: #fff;
    }
</style>