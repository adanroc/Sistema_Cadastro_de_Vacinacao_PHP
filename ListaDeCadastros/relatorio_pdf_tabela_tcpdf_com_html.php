<?php

// Iniciar a sessão no início do arquivo PHP
session_start();

// Obtém o protocolo correto (http ou https)
$protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$servidor = $_SERVER['HTTP_HOST']; // Obtém o IP/domínio + porta do servidor
$basePath = "/SisSASS"; // Obtém o diretório base do sistema
$baseURL = "$protocolo://$servidor$basePath"; // Define a URL base do sistema

include '../conexao.php';

require_once('../tcpdf/TCPDF-main/tcpdf.php');

date_default_timezone_set('America/Sao_Paulo'); // Definir o fuso horário para Brasília

class CustomPDF extends TCPDF {

    private $filename; // Propriedade para armazenar o nome do arquivo

    // Construtor personalizado para receber o nome do arquivo
    public function __construct($filename) {
        parent::__construct();
        $this->filename = $filename; // Armazena o nome do arquivo
    }

    // Cabeçalho do PDF
    public function Header() {
        
        // Caminho da Logo
        // $image_file = '../Logo-Hemopa-Para.png'; (não funciona nessa biblioteca)
        $image_file = '../Logo-Hemopa-Para.jpg';        

        // Verifica o número da página atual
        if ($this->getPage() == 1) {
        // Cabeçalho da primeira página

        // Logo
        $this->Image($image_file, 7, 1, 50, 15, '', '', '', false, 300, '', false, false, 0, false, false, false);

        // Texto do cabeçalho        
        $this->SetY(3); // Mantém a posição inicial do cabeçalho em relação à cima
        $this->SetFont('helvetica', '', 8);
        // $this->SetFont('helvetica', 'B', 8);
        $this->Cell(0, 3, 'Fundação Centro de Hemoterapia e Hematologia do Pará - Hemopa', 0, 1, 'C');
        // $this->SetFont('helvetica', '', 8);
        $this->Cell(0, 3, 'Serviço de Atendimento à Saúde do Servidor - SASS', 0, 1, 'C');
        $this->Cell(0, 3, 'Sistema de Cadastro de Vacinação dos Servidores - SCVS', 0, 1, 'C');

        // Linha separadora
        $this->Ln(2);
        $this->Cell(0, 0, '', 'T');
        $this->Ln(2);

        // // Informações de emissão
        // $this->SetFont('helvetica', '', 8);
        // $this->Cell(0, 10, 'Emitido por: UsuarioSistema | em: ' . date('d/m/Y H:i:s'), 0, 1, 'L');
        // $this->Ln(5);
        } else {
            // Cabeçalho da segunda página em diante

            //Logo           
            $this->Image($image_file, 7, 2, 40, 7, '', '', '', false, 300, '', false, false, 0, false, false, false);            

            //Texto
            $this->SetY(3);
            $this->SetFont('helvetica', 'B', 12);
            $this->Cell(0, 5, 'Relatório de Vacinação dos Servidores', 0, 1, 'C');
            $this->Ln(3);

        }
    }

    // Rodapé do PDF
    public function Footer() {        
        // Ocupa 2 linhas
        // $this->SetY(-20); // Subir mais a altura 
        // $this->SetFont('helvetica', '', 7);
        // $this->Cell(0, 10, 'Documento autenticado em ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        //  $filename = basename($_SERVER['PHP_SELF']); // Obtém o nome do arquivo
        // $this->Cell(0, 10, $filename, 0, 0, 'L'); // Nome do arquivo à esquerda
        // $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, 0, 'R');

        // Ocupa 1 linha
        $this->SetY(-15); //Altura Padrão 
        $this->SetFont('helvetica', '', 7);

        // Definição das larguras para os três elementos na mesma linha
        $larguraEsquerda = 50;  // Largura para o nome do arquivo
        $larguraCentro = 188;    // Largura para o "Documento autenticado"
        $larguraDireita = 50;   // Largura para a numeração de páginas
        
        // $filename = basename($_SERVER['PHP_SELF']); // Obtém o nome do arquivo        

        // Nome do arquivo (Alinhado à esquerda)
        // $this->Cell($larguraEsquerda, 10, $filename, 0, 0, 'L'); // Sem Construturo

        // Nome do arquivo (Alinhado à esquerda)
        $this->Cell($larguraEsquerda, 10, $this->filename, 0, 0, 'L'); // Com construtor

        // Documento autenticado (Centralizado)
        $this->Cell($larguraCentro, 10, 'Documento autenticado em ' . date('d/m/Y H:i:s'), 0, 0, 'C');
    
        // Numeração da página (Alinhado à direita)
        $this->Cell($larguraDireita, 10, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, 0, 'R');
    
    }
}

// Criando o nome do arquivo dinamicamente
$filename = 'relatorio_vacinacao_' . date('Ymd_His') . '.pdf';

// $pdf = new CustomPDF(); // Sem construtor
$pdf = new CustomPDF($filename); // Com construtor
// $pdf->SetAutoPageBreak(true, 20); // Permite quebra automática de página com margem inferior de 20
// $pdf->AddPage();
$pdf->AddPage('L'); // **Define a página como paisagem**
// $pdf->SetFont('helvetica', '', 7);

$pdf->SetY(20); //Altura 
// Título da tabela
$pdf->SetFont('helvetica', '', 12);
// $pdf->SetFont('nome fonte', estilo fonte, tamanho fonte);
// 'helvetica' → Nome da fonte (Helvetica, uma fonte padrão do TCPDF).
// '' → Estilo da fonte (pode ser 'B' para negrito, 'I' para itálico, 'U' para sublinhado ou combinações como 'BI' para negrito e itálico).
// 12 → Tamanho da fonte em pontos.
$pdf->Cell(0, 3, 'Relatório de Vacinação dos Servidores', 0, 1, 'C');
$pdf->Ln(3);
//Explicação: $pdf->Cell(largura, altura, texto, borda, posição, alinhamento);
// $pdf->Ln(3);
// New Line: pular uma linha:
// Adiciona um espaçamento vertical de 3 unidades (normalmente em milímetros), equivalente a um "enter" no PDF.
// Isso move o cursor de escrita para baixo em 3 unidades antes de adicionar mais conteúdo.

$pdf->SetFont('helvetica', '', 7);
// Informações de emissão
$pdf->Cell(0, 4, 'Relatório emitido por: UsuarioSistema, em: ' . date('d/m/Y H:i:s'), 0, 1, 'L');
// Resumo dos dados
// Balanço geral da tabela
$pdf->Cell(0, 4, 'Total de Servidores: X, Vacinados Completamente: X, Vacinados Parcialmente: X, Nenhuma Vacina Aplicada: X', 0, 1, 'L');
// Filtro
$pdf->Cell(0, 4, 'Filtro: Sem Filtro', 0, 1, 'L');
$pdf->Ln(3);

// Cabeçalho da tabela
$header = '<table border="1" cellpadding="3" style="text-align: center; vertical-align: middle;">
            <thead>
                <tr style="background-color: #ddd; font-weight: bold;">
                    <th colspan="9">Servidor Ativo</th>
                    <th colspan="4">Hepatite B (HB)</th>
                    <th colspan="2">Anti-HBS</th>
                    <th colspan="4">Difteria e Tétano (DT)</th>
                    <th colspan="2">Tríplice Viral</th>
                    <th colspan="5">Covid-19</th>
                    <th>Febre Amarela</th>
                    <th>Influenza</th>
                </tr>
                <tr style="background-color: #ddd; font-weight: bold;">
                    <th>#</th><th>Matrícula</th><th>Nome</th>
                    <th>DT Nascimento</th><th>Setor</th><th>Cargo</th><th>Unidade</th><th>Município</th><th>Status de Vacinação</th>
                    <th>1ªDose</th><th>2ªDose</th><th>3ªDose</th><th>Reforço</th>
                    <th>Exame</th><th>Resultado</th>
                    <th>1ªDose</th><th>2ªDose</th><th>3ªDose</th><th>Reforço</th>
                    <th>1ªDose</th><th>2ªDose</th>
                    <th>1ªDose</th><th>2ªDose</th><th>3ªDose</th><th>1ªReforço</th><th>2ªReforço</th>
                    <th>Dose Única</th><th>Dose Anual</th>
                </tr>
            </thead>
            <tbody>';
// echo "\n"
// Gerar dados fictícios
$totalRegistros = 77;
$html = '';
for ($i = 1; $i <= $totalRegistros; $i++) {
    // keepTogether="true" // Impede a quebra da linha em duas páginas
    $html .= '<tr  keepTogether="true" keepWithNext="true">
                <td>' . $i . '</td><td>12345' . $i . '</td><td>Servidor ' . $i . '</td>
                <td>01/01/1990</td><td>Setor ' . $i . '</td><td>Cargo ' . $i . '</td><td>Unidade ' . $i . '</td><td>Município ' . $i . '</td><td>Completa</td>
                <td>X</td><td>X</td><td>X</td><td>X</td>
                <td>X</td><td>X</td>
                <td>X</td><td>X</td><td>X</td><td>X</td>
                <td>X</td><td>X</td>
                <td>X</td><td>X</td><td>X</td><td>X</td><td>X</td>
                <td>X</td><td>X</td>
              </tr>';
}
$html .= '</tbody>';
// Rodapé da tabela
$html .= '<tfoot>
          <tr style="background-color: #e4c16f; font-weight: bold;">
            <th colspan="9">Total por Dose</th>
            <td colspan="19"></td>
          </tr>
          <tr style="background-color: #e4c16f; font-weight: bold;">
            <td colspan="9">Total por Vacina</td>
            <td colspan="19"></td>
          </tr>
        </tfoot>';
$html .= '</table>';


// Escrever a tabela no PDF
$pdf->writeHTML($header . $html, true, false, false, false, '');

// Gerar o PDF
// $pdf->Output('relatorio_vacinacao_' . date('Ymd_His') . '.pdf', 'I'); // Sem construtor

// Saída do PDF com o nome correto
$pdf->Output($filename, 'I'); // Com construtor