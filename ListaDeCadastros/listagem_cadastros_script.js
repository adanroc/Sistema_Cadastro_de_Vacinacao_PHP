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


document.querySelectorAll(".bi-copy").forEach((IconeCopiar) => {

// Botão de copiar e Mensagem de copiado (só pega o primeiro botão)
// const IconeCopiar = document.getElementById("copiar");

// Captura o tamanho original do ícone antes da alteração
const tamanhoOriginal = window.getComputedStyle(IconeCopiar).fontSize;

// Obtém posição do ícone 
const rect = IconeCopiar.getBoundingClientRect(); 

IconeCopiar.addEventListener("click", function() {    
    
    // Obtém a linha correspondente ao botão de copiar
    const linha = IconeCopiar.closest("tr"); // A linha da tabela que contém o botão

    // Obtém e Formata os Dados que deseja para a área de transferência
    let dados = "";

    // Funcionando (teste)
    // const cabecalhos = document.querySelectorAll("thead th"); // Captura os nomes das colunas
    // cabecalhos.forEach((th, index) => {
    //     const nomeColuna = th.innerText.trim();
    //     // console.log(`📌 Coluna ${index + 1}: "${nomeColuna}"`); // Debug
    //     if (nomeColuna) {
    //         dados += nomeColuna + ", ";
    //     }        
    // });

    // Obtém as linhas do cabeçalho da tabela
const cabecalhoLinhas = document.querySelectorAll("thead tr");

// Verifica se há pelo menos duas linhas no cabeçalho
if (cabecalhoLinhas.length >= 2) {
    let primeiraLinha = "";
    let segundaLinha = "";

    // Captura os textos da primeira linha do cabeçalho
    cabecalhoLinhas[0].querySelectorAll("th").forEach((th, index) => {
        const texto = th.innerText.trim();
        console.log(`📌 Primeira linha - Coluna ${index + 1}: "${texto}"`);
        if (texto) {
            primeiraLinha += texto + ", ";
        }
    });

    // Captura os textos da segunda linha do cabeçalho
    cabecalhoLinhas[1].querySelectorAll("th").forEach((th, index) => {
        const texto = th.innerText.trim();
        console.log(`📌 Segunda linha - Coluna ${index + 1}: "${texto}"`);
        // if (texto) { // Pega todas as colunas
        //     segundaLinha += texto + ", ";
        // }
        if (texto !== "Ação") {  // Ignora a coluna "Ação"
            segundaLinha += texto + ", ";
        }
    });

    // Remove a última vírgula e espaço, e adiciona um ponto final se houver conteúdo
    primeiraLinha = primeiraLinha.replace(/, $/, "") + ".";
    segundaLinha = segundaLinha.replace(/, $/, "") + ".";

    // Junta as duas linhas separadas por uma quebra de linha
    dados = primeiraLinha + "\n" + segundaLinha;
    }

    // Agora, captura os dados da linha correspondente ao usuário
    let linhaTexto = "";

    // Obtém as células (colunas) dessa linha
    const colunas = linha.querySelectorAll("td");
            
    // Adiciona os dados da linha, sem a coluna "Ação"
    colunas.forEach((coluna, index) => {
        const textoColuna = coluna.innerText.trim();
            if (index !== 0) { // Ignora a coluna "Ação", que está na primeira posição
                linhaTexto += textoColuna + ", ";
            }
        });
    
    // Remove a última vírgula e adiciona ponto final
    linhaTexto = linhaTexto.replace(/, $/, "") + ".";
            
    // Adiciona os dados da linha no texto a ser copiado
    dados += "\n" + linhaTexto;  

    // Copia os dados usando a API moderna
    navigator.clipboard.writeText(dados).then(() => {

        // Alterar ícone e exibir "Copiado"
        IconeCopiar.classList.replace("bi-copy", "bi-check2");
        IconeCopiar.style.color = "green";
        IconeCopiar.style.fontSize = "1.5rem";
        IconeCopiar.setAttribute("title", "Copiado para a Área de Transferência!");

        //  ------------------- Criar e Exibir a mensagem de feedback -------------------
        // Criar dinamicamente o elemento da mensagem, do tipo span
        const feedback = document.createElement("span");
        feedback.textContent = "Copiado!";
        document.body.appendChild(feedback);

        // Estilos da mensagem
        feedback.style.background = "black";
        feedback.style.color = "white";
        feedback.style.padding = "5px 10px";
        feedback.style.borderRadius = "5px";
        feedback.style.fontSize = "14px";
        feedback.style.whiteSpace = "nowrap";
        feedback.style.transition = "opacity 0.3s ease-in-out";
        feedback.style.opacity = "1";

        // Adiciona a setinha embaixo da caixa de mensagem, semelhante a um balão de diálogo
        // Estilo
        // Posicionamento


        // Posição da Mensagem
        // Posicionamento dinâmico acima do ícone (dado que, o ícone está dentro de uma tabela) - não está funcionand
        // feedback.style.position = "absolute";
        // const rect = IconeCopiar.getBoundingClientRect(); // Obtém posição do ícone
        // feedback.style.top = `${rect.top - 50}px`; // Ajuste para cima 
        // feedback.style.left = `${rect.left + rect.width / 2 - feedback.offsetWidth / 2}px`; // Centraliza acima do ícone
        // feedback.style.zIndex = "9999";  // Garante que fique na frente (da tabela por exemplo)

        // Fixo do lado inferior esquerdo
        //   feedback.style.position = "fixed";  // Fixo na tela
        //   feedback.style.bottom = "20px";  // Distância do rodapé
        //   feedback.style.left = "20px";  // Distância da lateral esquerda

        // Fixo No topo da página centralizado 
        //   feedback.style.position = "absolute";
        //   feedback.style.top = "30px";  
        //   feedback.style.left = "50%";
        //   feedback.style.transform = "translateX(-50%)"; // Centraliza

        // Fixo acima do ícone e da tabela (funcionando como deveria)
        feedback.style.position = "absolute";
        feedback.style.top = "280px";  
        feedback.style.left = "5%";
        feedback.style.transform = "translateX(-50%)"; // Centraliza    

        // Reverte as mudanças após 3,5 segundos
        setTimeout(() => {
            IconeCopiar.classList.replace("bi-check2", "bi-copy");
            IconeCopiar.style.color = ""; // Retorna à cor padrão
            IconeCopiar.style.fontSize = tamanhoOriginal; // Retorna ao tamanho original
            IconeCopiar.setAttribute("title", "Copiar dados do servidor para a área de transferência");              
           
            // Esconder mensagem suavemente
            feedback.style.opacity = "0";
            setTimeout(() => feedback.remove(), 300);
        }, 3500); 

    }).catch(err => {
        console.error("Erro ao copiar para a área de transferência:", err);
    }); 
});
});

// Estilo para o tooltip (conteúdo elipsado da célula pelo JavaScritp)
// Exibir a legenda do texto e permitir selecionar e copiar o texto: 
document.addEventListener("DOMContentLoaded", function () {
    const tableCells = document.querySelectorAll("#TabelaListaDeCadastros td");

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
            $('#TabelaListaDeCadastros tbody tr').show(); // Exibe todas as linhas
            return;
        }

        // Filtra as linhas da tabela
        $('#TabelaListaDeCadastros tbody tr').each(function () {
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
    getDatatable('#TabelaListaDeCadastros');
    // getDatatable('#TabelaListaDeUsuarios');
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

