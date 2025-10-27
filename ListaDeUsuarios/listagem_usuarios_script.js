// Fechar mensagem de aviso de erro ou sucesso
$(document).ready(function () {
    // Fecha o alerta ao clicar no botão "x"
    $('.close-alert').click(function () {
        $('#alert-box').addClass('fade-out').delay(500).queue(function () {
            $(this).remove();
        });
    });

    // Fecha o alerta ao clicar fora da mensagem
    $(document).mouseup(function (e) {
        var container = $('#alert-box');
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.addClass('fade-out').delay(500).queue(function () {
                $(this).remove();
            });
        }
    });
});


// Estilo para o tooltip (conteúdo elipsado da célula pelo JavaScritp)
// Exibir a legenda do texto e permitir selecionar e copiar o texto: 
document.addEventListener("DOMContentLoaded", function () {
    const tableCells = document.querySelectorAll("#TabelaListaDeUsuarios td");

    tableCells.forEach(cell => {
        cell.addEventListener("mouseenter", function (e) {
            if (cell.scrollWidth > cell.clientWidth) {
                const tooltip = document.createElement("div");
                tooltip.className = "tooltip";
                tooltip.innerText = cell.innerText;

                document.body.appendChild(tooltip);

                const rect = cell.getBoundingClientRect();
                tooltip.style.left = `${rect.left + window.scrollX}px`;
                tooltip.style.top = `${rect.bottom + window.scrollY + 5}px`;
                tooltip.style.visibility = "visible";
                tooltip.style.opacity = "1";

                // Salva referência ao tooltip
                cell._tooltip = tooltip;

                // Adiciona eventos ao tooltip para mantê-lo visível
                tooltip.addEventListener("mouseenter", () => {
                    tooltip.style.visibility = "visible";
                    tooltip.style.opacity = "1";
                });

                tooltip.addEventListener("mouseleave", () => {
                    tooltip.remove();
                    cell._tooltip = null;
                });
            }
        });

        cell.addEventListener("mouseleave", function () {
            if (cell._tooltip) {
                // Adiciona pequeno atraso para permitir que o cursor alcance o tooltip
                setTimeout(() => {
                    if (cell._tooltip && !cell._tooltip.matches(':hover')) {
                        cell._tooltip.remove();
                        cell._tooltip = null;
                    }
                }, 100); // 100ms para suavizar a transição
            }
        });
    });
});

$(document).ready(function () {

    // Filtro Geral 
    // Filtro global - aplica busca em todas as colunas
    $('#FiltroGeral').on('input', function () {
        const filtroGeral = $(this).val().toLowerCase().trim(); // Captura o valor do campo de filtro e converte para minúsculo
        let encontrouResultado = false; // Flag para verificar se algum resultado foi encontrado

        // Verifica se o filtro contém pelo menos um caractere
        if (filtroGeral.length < 1) {
            $('#nenhumResultado').hide(); // Se o filtro estiver vazio, esconde a mensagem
            $('#TabelaListaDeUsuarios tbody tr').show(); // Exibe todas as linhas
            return;
        }

        // Filtra as linhas da tabela
        $('#TabelaListaDeUsuarios tbody tr').each(function () {
            let linhaVisivel = false; // Flag para verificar se a linha deve ser visível

            // Verifica todas as células da linha
            $(this).find('td').each(function () {
                const celulaTexto = $(this).text().toLowerCase(); // Captura o texto da célula e converte para minúsculo
                if (celulaTexto.includes(filtroGeral)) {
                    linhaVisivel = true; // Se qualquer célula contiver o filtro, a linha deve ser visível
                }
            });

            // Aplica o filtro à linha, mostrando ou ocultando
            $(this).toggle(linhaVisivel);

            // Se a linha for visível, altera a flag
            if (linhaVisivel) {
                encontrouResultado = true;
            }
        });

        // Exibe ou oculta a mensagem de "Nenhum cadastro foi encontrado"
        if (encontrouResultado) {
            $('#nenhumResultadoRow').hide(); // Oculta a mensagem de nenhum resultado
        } else {
            $('#nenhumResultadoRow').show(); // Exibe a mensagem se não houver resultados
        }
    });
});

 //Método 2 - fonte site JQuery DataTable
 $(document).ready(function () {    
    // getDatatable('#TabelaListaDeCadastros');
    getDatatable('#TabelaListaDeUsuarios');
});

 //Tradução git-hub Acaciano Neves - Programador Tech (função de paginação desativada junto com sua legenda)
 function getDatatable(id)
 {
     $(id).DataTable({
         "ordering": true, // Ordenação habilitada
         "paging": false, // Paginação habilitada
         "searching": false, //pesquisa habilitada
         "oLanguage": {
             "sEmptyTable": "Nenhum registro encontrado na tabela",
             "sInfo": "",
             "sInfoEmpty": "",
             "sInfoFiltered": "(Filtrar de _MAX_ total registros)",
             "sInfoPostFix": "",
             "sInfoThousands": ".",
             "sLengthMenu": "Mostrar _MENU_ registros por pagina",
             "sLoadingRecords": "Carregando...",
             "sProcessing": "Processando...",
             "sZeroRecords": "Nenhum registro encontrado",
             "sSearch": "Pesquisar",
             "oPaginate": {
                 "sNext": "Proximo",
                 "sPrevious": "Anterior",
                 "sFirst": "Primeiro",
                 "sLast": "Ultimo"
             },
             "oAria": {
                 "sSortAscending": ": Ordenar colunas de forma ascendente",
                 "sSortDescending": ": Ordenar colunas de forma descendente"
             }
         }
     });  
 }

//Código completo
//function getDatatable(id) {
//    $(id).DataTable({
//        "ordering": true, // Ordenação habilitada
//        "paging": true, // Paginação habilitada
//        "searching": true, //pesquisa habilitada
//        "oLanguage": {
//            "sEmptyTable": "Nenhum registro encontrado na tabela",
//            "sInfo": "Mostrar _START_ até _END_ de _TOTAL_ registros",
//            "sInfoEmpty": "Mostrar 0 até 0 de 0 Registros",
//            "sInfoFiltered": "(Filtrar de _MAX_ total registros)",
//            "sInfoPostFix": "",
//            "sInfoThousands": ".",
//            "sLengthMenu": "Mostrar _MENU_ registros por pagina",
//            "sLoadingRecords": "Carregando...",
//            "sProcessing": "Processando...",
//            "sZeroRecords": "Nenhum registro encontrado",
//            "sSearch": "Pesquisar",
//            "oPaginate": {
//                "sNext": "Proximo",
//                "sPrevious": "Anterior",
//                "sFirst": "Primeiro",
//                "sLast": "Ultimo"
//            },
//            "oAria": {
//                "sSortAscending": ": Ordenar colunas de forma ascendente",
//                "sSortDescending": ": Ordenar colunas de forma descendente"
//            }
//        }
//    });
//}