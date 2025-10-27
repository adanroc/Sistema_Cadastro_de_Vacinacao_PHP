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

        // Ocupa 1 linha
        $this->SetY(-15); //Altura Padrão 
        $this->SetFont('helvetica', '', 7);

        // Definição das larguras para os três elementos na mesma linha
        $larguraEsquerda = 50;  // Largura para o nome do arquivo
        $larguraCentro = 188;    // Largura para o "Documento autenticado"
        $larguraDireita = 50;   // Largura para a numeração de páginas
       
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

$pdf = new CustomPDF($filename);
$pdf->AddPage('L'); // Página em paisagem
$pdf->SetFont('helvetica', '', 7);
$pdf->SetY(20);

// Título da Tabela
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 6, 'Relatório de Vacinação dos Servidores', 0, 1, 'C');
$pdf->Ln(3);

// Informações adicionais
$pdf->SetFont('helvetica', '', 7);
$pdf->Cell(0, 4, 'Relatório emitido por: UsuarioSistema, em: ' . date('d/m/Y H:i:s'), 0, 1, 'L');
$pdf->Cell(0, 4, 'Total de Servidores: X, Vacinados Completamente: X, Parcialmente: X, Nenhuma Vacina: X', 0, 1, 'L');
$pdf->Cell(0, 4, 'Filtro: Sem Filtro', 0, 1, 'L');
$pdf->Ln(3);

// Definição do cabeçalho da tabela
$pdf->SetFont('helvetica', 'B', 7);
$pdf->SetFillColor(200, 200, 200);

$header = ['#', 'Matrícula', 'Nome', 'DT Nascimento', 'Setor', 'Cargo', 'Unidade', 'Município', 'Status',
           'HB 1ªDose', 'HB 2ªDose', 'HB 3ªDose', 'HB Reforço', 'Anti-HBS Exame', 'Resultado',
           'DT 1ªDose', 'DT 2ªDose', 'DT 3ªDose', 'DT Reforço', 'Tríplice 1ªDose', 'Tríplice 2ªDose',
           'Covid 1ªDose', 'Covid 2ªDose', 'Covid 3ªDose', 'Covid 1ºReforço', 'Covid 2ºReforço',
           'Febre Amarela', 'Influenza'];

$widths = [7, 15, 35, 18, 22, 22, 22, 22, 20, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12, 12];

// Criando o cabeçalho da tabela
foreach ($header as $index => $col) {
    $pdf->Cell($widths[$index], 6, $col, 1, 0, 'C', true);
}
$pdf->Ln();

// Gerando os dados da tabela
$pdf->SetFont('helvetica', '', 7);
$totalRegistros = 77;
for ($i = 1; $i <= $totalRegistros; $i++) {
    // Verifica se precisa adicionar uma nova página
    if ($pdf->GetY() > 190) {
        $pdf->AddPage('L');
        foreach ($header as $index => $col) {
            $pdf->Cell($widths[$index], 6, $col, 1, 0, 'C', true);
        }
        $pdf->Ln();
    }

    // Preenchendo as células
    $dados = [$i, '12345' . $i, 'Servidor ' . $i, '01/01/1990', 'Setor ' . $i, 'Cargo ' . $i, 'Unidade ' . $i, 'Município ' . $i, 'Completa',
              'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'];

    foreach ($dados as $index => $dado) {
        $pdf->Cell($widths[$index], 6, $dado, 1, 0, 'C');
    }
    $pdf->Ln();
}

// Saída do PDF
$pdf->Output($filename, 'I');

