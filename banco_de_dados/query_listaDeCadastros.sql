-- Criar o banco de dados se não existir
CREATE DATABASE IF NOT EXISTS SisSASS;

-- Selecionar o banco de dados que será utilizado
USE SisSASS;

SHOW CREATE TABLE listadecadastros
DROP TABLE IF EXISTS ListaDeCadastros;

-- Eschemas da Tabela
Table: listadecadastros
Columns:
idServidor int AI PK 
IdUsuarioCadastrou int 
dataCadastro datetime 
IdUsuarioUltimaEdicao int 
dataUltimaEdicao datetime 
apagadoFalso enum('0','1') 
IdUsuarioApagou int 
dataApagado datetime 
nome varchar(255) 
numMatricula varchar(100) 
dataNascimento datetime 
cargo varchar(255) 
setor varchar(100) 
unidade varchar(100) 
municipio varchar(100) 
statusVacinacao enum('1','2','3') 
dataDose1HepatiteB datetime 
dataDose2HepatiteB datetime 
dataDose3HepatiteB datetime 
dataDoseReforcoHepatiteB datetime 
dataExameAntiHBS datetime 
resultadoExameAntiHBS varchar(100) 
dataDose1DifteriaTetano datetime 
dataDose2DifteriaTetano datetime 
dataDose3DifteriaTetano datetime 
dataDoseReforcoDifteriaTetano datetime 
dataDose1TripliceViral datetime 
dataDose2TripliceViral datetime 
dataDose1Covid datetime 
dataDose2Covid datetime 
dataDose3Covid datetime 
dataDoseReforco1Covid datetime 
dataDoseReforco2Covid datetime 
dataDoseUnicaFebreAmarela datetime 
dataDoseAnualInfluenza datetime

-- Populando tabela

-- Cadastro do Usuário Adm
-- Datas tipo DATETIME
INSERT INTO ListaDeCadastros (
    nome, numMatricula, IdUsuarioCadastrou, dataCadastro, dataNascimento, setor, cargo, unidade, municipio,
    dataDose1HepatiteB, dataDose2HepatiteB, dataDose3HepatiteB, dataDoseReforcoHepatiteB,
    dataExameAntiHBS, resultadoExameAntiHBS,
    dataDose1DifteriaTetano, dataDose2DifteriaTetano, dataDose3DifteriaTetano, dataDoseReforcoDifteriaTetano,
    dataDose1TripliceViral, dataDose2TripliceViral,
    dataDose1Covid, dataDose2Covid, dataDose3Covid, dataDoseReforco1Covid, dataDoseReforco2Covid,
    dataDoseUnicaFebreAmarela, dataDoseAnualInfluenza
) VALUES 
-- Cadastro completo (22 cadastros)
    ('Carlos Eduardo', '10000', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), NOW(), 
    'TI', 'Gerente', 'Sede', 'Belém',
    NOW(), NOW(), NOW(), NOW(),
    NOW(), 'Positivo',
    NOW(), NOW(), NOW(), NOW(),
    NOW(), NOW(),
    NOW(), NOW(), NOW(), NOW(), NOW(),
    NOW(), NOW()),
    ('Lucas Almeida', '10001', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), '2004-01-10', '1985-07-15', 'TI', 'Analista', 'Sede', 'Belém', '2004-02-15', '2004-03-20', '2004-04-25', '2004-05-30', '2004-06-05', 'Positivo', '2004-07-10', '2004-08-15', '2004-09-20', '2004-10-25', '2004-11-30', '2004-12-05', '2004-12-10', '2004-12-15', '2004-12-20', '2004-12-25', '2004-12-30', '2004-12-31', '2004-06-15'),
    ('Mariana Souza', '10002', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1978-06-20', 'RH', 'Coordenador', 'Filial', 'São Paulo', '2005-02-15', '2005-03-20', '2005-04-25', '2005-05-30', '2005-06-05', 'Negativo', '2005-07-10', '2005-08-15', '2005-09-20', '2005-10-25', '2005-11-30', '2005-12-05', '2005-12-10', '2005-12-15', '2005-12-20', '2005-12-25', '2005-12-30', '2005-12-31', '2005-06-15'),
    ('Ricardo Mendes', '10003', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1990-08-25', 'Financeiro', 'Gerente', 'Sede', 'Curitiba', '2006-02-15', '2006-03-20', '2006-04-25', '2006-05-30', '2006-06-05', 'Positivo', '2006-07-10', '2006-08-15', '2006-09-20', '2006-10-25', '2006-11-30', '2006-12-05', '2006-12-10', '2006-12-15', '2006-12-20', '2006-12-25', '2006-12-30', '2006-12-31', '2006-06-15'),
    ('Amanda Ribeiro', '10004', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1975-05-12', 'Vendas', 'Supervisor', 'Filial', 'Rio de Janeiro', '2007-02-15', '2007-03-20', '2007-04-25', '2007-05-30', '2007-06-05', 'Negativo', '2007-07-10', '2007-08-15', '2007-09-20', '2007-10-25', '2007-11-30', '2007-12-05', '2007-12-10', '2007-12-15', '2007-12-20', '2007-12-25', '2007-12-30', '2007-12-31', '2007-06-15'),
    ('Gabriel Santos', '10005', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1982-10-18', 'TI', 'Desenvolvedor', 'Sede', 'Belo Horizonte', '2008-02-15', '2008-03-20', '2008-04-25', '2008-05-30', '2008-06-05', 'Positivo', '2008-07-10', '2008-08-15', '2008-09-20', '2008-10-25', '2008-11-30', '2008-12-05', '2008-12-10', '2008-12-15', '2008-12-20', '2008-12-25', '2008-12-30', '2008-12-31', '2008-06-15'),
    ('Fernanda Lima', '10006', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1995-11-25', 'Marketing', 'Coordenador', 'Sede', 'Fortaleza', '2009-02-15', '2009-03-20', '2009-04-25', '2009-05-30', '2009-06-05', 'Negativo', '2009-07-10', '2009-08-15', '2009-09-20', '2009-10-25', '2009-11-30', '2009-12-05', '2009-12-10', '2009-12-15', '2009-12-20', '2009-12-25', '2009-12-30', '2009-12-31', '2009-06-15'),
    ('Cláudio Fernandes', '10007', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1988-03-05', 'Suporte', 'Técnico', 'Sede', 'Recife', '2010-02-15', '2010-03-20', '2010-04-25', '2010-05-30', '2010-06-05', 'Positivo', '2010-07-10', '2010-08-15', '2010-09-20', '2010-10-25', '2010-11-30', '2010-12-05', '2010-12-10', '2010-12-15', '2010-12-20', '2010-12-25', '2010-12-30', '2010-12-31', '2010-06-15'),
    ('Beatriz Nogueira', '10008', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1992-07-22', 'Recursos Humanos', 'Analista', 'Filial', 'Porto Alegre', '2011-02-15', '2011-03-20', '2011-04-25', '2011-05-30', '2011-06-05', 'Negativo', '2011-07-10', '2011-08-15', '2011-09-20', '2011-10-25', '2011-11-30', '2011-12-05', '2011-12-10', '2011-12-15', '2011-12-20', '2011-12-25', '2011-12-30', '2011-12-31', '2011-06-15'),
    ('Roberto Silveira', '10009', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1977-12-10', 'Financeiro', 'Assistente', 'Sede', 'Goiânia', '2012-02-15', '2012-03-20', '2012-04-25', '2012-05-30', '2012-06-05', 'Positivo', '2012-07-10', '2012-08-15', '2012-09-20', '2012-10-25', '2012-11-30', '2012-12-05', '2012-12-10', '2012-12-15', '2012-12-20', '2012-12-25', '2012-12-30', '2012-12-31', '2012-06-15'),
    ('Vanessa Cardoso', '10010', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1985-04-18', 'Marketing', 'Supervisor', 'Filial', 'Manaus', '2013-02-15', '2013-03-20', '2013-04-25', '2013-05-30', '2013-06-05', 'Negativo', '2013-07-10', '2013-08-15', '2013-09-20', '2013-10-25', '2013-11-30', '2013-12-05', '2013-12-10', '2013-12-15', '2013-12-20', '2013-12-25', '2013-12-30', '2013-12-31', '2013-06-15'),
    ('Thiago Ferreira', '10011', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1991-09-30', 'Logística', 'Coordenador', 'Sede', 'Natal', '2014-02-15', '2014-03-20', '2014-04-25', '2014-05-30', '2014-06-05', 'Positivo', '2014-07-10', '2014-08-15', '2014-09-20', '2014-10-25', '2014-11-30', '2014-12-05', '2014-12-10', '2014-12-15', '2014-12-20', '2014-12-25', '2014-12-30', '2014-12-31', '2014-06-15'),
    ('Patrícia Farias', '10012', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1984-02-28', 'Vendas', 'Gerente', 'Filial', 'São Luís', '2015-02-15', '2015-03-20', '2015-04-25', '2015-05-30', '2015-06-05', 'Negativo', '2015-07-10', '2015-08-15', '2015-09-20', '2015-10-25', '2015-11-30', '2015-12-05', '2015-12-10', '2015-12-15', '2015-12-20', '2015-12-25', '2015-12-30', '2015-12-31', '2015-06-15'),
    ('Renato Oliveira', '10013', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1976-06-09', 'Financeiro', 'Diretor', 'Sede', 'Salvador', '2016-02-15', '2016-03-20', '2016-04-25', '2016-05-30', '2016-06-05', 'Positivo', '2016-07-10', '2016-08-15', '2016-09-20', '2016-10-25', '2016-11-30', '2016-12-05', '2016-12-10', '2016-12-15', '2016-12-20', '2016-12-25', '2016-12-30', '2016-12-31', '2016-06-15'),
    ('Fernanda Souza', '10014', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1983-05-14', 'Jurídico', 'Advogada', 'Sede', 'Curitiba', '2017-02-15', '2017-03-20', '2017-04-25', '2017-05-30', '2017-06-05', 'Negativo', '2017-07-10', '2017-08-15', '2017-09-20', '2017-10-25', '2017-11-30', '2017-12-05', '2017-12-10', '2017-12-15', '2017-12-20', '2017-12-25', '2017-12-30', '2017-12-31', '2017-06-15'),
    ('João Marcos', '10015', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1990-08-21', 'TI', 'Analista', 'Filial', 'Brasília', '2018-02-15', '2018-03-20', '2018-04-25', '2018-05-30', '2018-06-05', 'Positivo', '2018-07-10', '2018-08-15', '2018-09-20', '2018-10-25', '2018-11-30', '2018-12-05', '2018-12-10', '2018-12-15', '2018-12-20', '2018-12-25', '2018-12-30', '2018-12-31', '2018-06-15'),
    ('Sabrina Lima', '10016', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1987-11-03', 'RH', 'Supervisora', 'Sede', 'Fortaleza', '2019-02-15', '2019-03-20', '2019-04-25', '2019-05-30', '2019-06-05', 'Negativo', '2019-07-10', '2019-08-15', '2019-09-20', '2019-10-25', '2019-11-30', '2019-12-05', '2019-12-10', '2019-12-15', '2019-12-20', '2019-12-25', '2019-12-30', '2019-12-31', '2019-06-15'),
    ('Gustavo Andrade', '10017', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1979-09-15', 'Financeiro', 'Contador', 'Filial', 'Rio de Janeiro', '2020-02-15', '2020-03-20', '2020-04-25', '2020-05-30', '2020-06-05', 'Positivo', '2020-07-10', '2020-08-15', '2020-09-20', '2020-10-25', '2020-11-30', '2020-12-05', '2020-12-10', '2020-12-15', '2020-12-20', '2020-12-25', '2020-12-30', '2020-12-31', '2020-06-15'),
    ('Tatiane Melo', '10018', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1993-06-27', 'Vendas', 'Assistente', 'Sede', 'Belo Horizonte', '2021-02-15', '2021-03-20', '2021-04-25', '2021-05-30', '2021-06-05', 'Negativo', '2021-07-10', '2021-08-15', '2021-09-20', '2021-10-25', '2021-11-30', '2021-12-05', '2021-12-10', '2021-12-15', '2021-12-20', '2021-12-25', '2021-12-30', '2021-12-31', '2021-06-15'),
    ('Ricardo Alves', '10019', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1981-02-05', 'Logística', 'Operador', 'Filial', 'Porto Alegre', '2022-02-15', '2022-03-20', '2022-04-25', '2022-05-30', '2022-06-05', 'Positivo', '2022-07-10', '2022-08-15', '2022-09-20', '2022-10-25', '2022-11-30', '2022-12-05', '2022-12-10', '2022-12-15', '2022-12-20', '2022-12-25', '2022-12-30', '2022-12-31', '2022-06-15'),
    ('Helena Dias', '10020', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1975-07-19', 'Jurídico', 'Consultora', 'Sede', 'Recife', '2023-02-15', '2023-03-20', '2023-04-25', '2023-05-30', '2023-06-05', 'Negativo', '2023-07-10', '2023-08-15', '2023-09-20', '2023-10-25', '2023-11-30', '2023-12-05', '2023-12-10', '2023-12-15', '2023-12-20', '2023-12-25', '2023-12-30', '2023-12-31', '2023-06-15'),
    ('Marcos Pereira', '10021', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), NOW(), '1980-03-14', 'Financeiro', 'Analista', 'Filial', 'Salvador', '2024-02-15', '2024-03-20', '2024-04-25', '2024-05-30', '2024-06-05', 'Positivo', '2024-07-10', '2024-08-15', '2024-09-20', '2024-10-25', '2024-11-30', '2024-12-05', '2024-12-10', '2024-12-15', '2024-12-20', '2024-12-25', '2024-12-30', '2024-12-31', '2024-06-15');

-- Cadastros do usuário admin
-- Cadastro completo (9 cadastros) com datas da década de 1990
INSERT INTO ListaDeCadastros (
    nome, numMatricula, IdUsuarioCadastrou, dataCadastro, dataNascimento, setor, cargo, unidade, municipio,
    dataDose1HepatiteB, dataDose2HepatiteB, dataDose3HepatiteB, dataDoseReforcoHepatiteB,
    dataExameAntiHBS, resultadoExameAntiHBS,
    dataDose1DifteriaTetano, dataDose2DifteriaTetano, dataDose3DifteriaTetano, dataDoseReforcoDifteriaTetano,
    dataDose1TripliceViral, dataDose2TripliceViral,
    dataDose1Covid, dataDose2Covid, dataDose3Covid, dataDoseReforco1Covid, dataDoseReforco2Covid,
    dataDoseUnicaFebreAmarela, dataDoseAnualInfluenza
) VALUES 
    ('Carlos Eduardo', '10050', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), '1991-02-15', '1975-06-10', 
    'TI', 'Gerente', 'Sede', 'Belém',
    '1991-03-10', '1991-04-15', '1991-05-20', '1991-06-25',
    '1991-07-01', 'Positivo',
    '1991-08-05', '1991-09-10', '1991-10-15', '1991-11-20',
    '1991-12-01', '1991-12-15',
    '1991-06-01', '1991-07-05', '1991-08-10', '1991-09-15', '1991-10-20',
    '1991-11-25', '1991-12-30'),

    ('Mariana Souza', '10051', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), '1992-03-10', '1978-08-25',
    'RH', 'Coordenador', 'Filial', 'São Paulo',
    '1992-04-15', '1992-05-20', '1992-06-25', '1992-07-30',
    '1992-08-10', 'Negativo',
    '1992-09-15', '1992-10-20', '1992-11-25', '1992-12-30',
    '1992-06-01', '1992-07-05',
    '1992-08-10', '1992-09-15', '1992-10-20', '1992-11-25', '1992-12-30',
    '1992-06-15', '1992-12-05'),

    ('Ricardo Mendes', '10052', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), '1993-04-20', '1980-09-30',
    'Financeiro', 'Gerente', 'Sede', 'Curitiba',
    '1993-05-25', '1993-06-30', '1993-07-05', '1993-08-10',
    '1993-09-15', 'Positivo',
    '1993-10-20', '1993-11-25', '1993-12-30', '1993-06-01',
    '1993-07-05', '1993-08-10',
    '1993-09-15', '1993-10-20', '1993-11-25', '1993-12-30', '1993-06-15',
    '1993-07-10', '1993-12-05'),

    ('Amanda Ribeiro', '10053', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), '1994-05-10', '1982-12-12',
    'Vendas', 'Supervisor', 'Filial', 'Rio de Janeiro',
    '1994-06-15', '1994-07-20', '1994-08-25', '1994-09-30',
    '1994-10-05', 'Negativo',
    '1994-11-10', '1994-12-15', '1994-06-01', '1994-07-05',
    '1994-08-10', '1994-09-15',
    '1994-10-20', '1994-11-25', '1994-12-30', '1994-06-15', '1994-07-10',
    '1994-12-05', '1994-12-31'),

    ('Gabriel Santos', '10054', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), '1995-06-20', '1984-07-18',
    'TI', 'Desenvolvedor', 'Sede', 'Belo Horizonte',
    '1995-07-25', '1995-08-30', '1995-09-05', '1995-10-10',
    '1995-11-15', 'Positivo',
    '1995-12-20', '1995-06-01', '1995-07-05', '1995-08-10',
    '1995-09-15', '1995-10-20',
    '1995-11-25', '1995-12-30', '1995-06-15', '1995-07-10', '1990-07-10',
    '1995-12-05', '1995-12-31'),

    ('Fernanda Lima', '10055', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), '1996-07-10', '1985-11-25',
    'Marketing', 'Coordenador', 'Sede', 'Fortaleza',
    '1996-08-15', '1996-09-20', '1996-10-25', '1996-11-30',
    '1996-12-05', 'Negativo',
    '1996-06-01', '1996-07-05', '1996-08-10', '1996-09-15',
    '1996-10-20', '1996-11-25',
    '1996-12-30', '1996-06-15', '1996-07-10', '1996-12-05', '1999-07-10',
    '1996-12-31', '1996-06-15'),

    ('Cláudio Fernandes', '10056', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), '1997-08-05', '1986-03-05',
    'Suporte', 'Técnico', 'Sede', 'Recife',
    '1997-09-10', '1997-10-15', '1997-11-20', '1997-12-25',
    '1997-06-01', 'Positivo',
    '1997-07-05', '1997-08-10', '1997-09-15', '1997-10-20',
    '1997-11-25', '1997-12-30',
    '1997-06-15', '1997-07-10', '1997-12-05', '1997-12-31', '1991-07-10',
    '1997-06-15', '1997-07-10'),

    ('Beatriz Nogueira', '10057', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), '1998-09-15', '1987-07-22',
    'RH', 'Analista', 'Filial', 'Porto Alegre',
    '1998-10-20', '1998-11-25', '1998-12-30', '1998-06-01',
    '1998-07-05', 'Negativo',
    '1998-08-10', '1998-09-15', '1998-10-20', '1998-11-25',
    '1998-12-30', '1998-06-15',
    '1998-07-10', '1998-12-05', '1998-12-31', '1998-06-15', '1992-07-10',
    '1998-07-10', '1998-12-05'),

    ('Roberto Silveira', '10058', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), '1999-10-25', '1988-12-10',
    'Financeiro', 'Assistente', 'Sede', 'Goiânia',
    '1999-11-30', '1999-12-05', '1999-06-01', '1999-07-05',
    '1999-08-10', 'Positivo',
    '1999-09-15', '1999-10-20', '1999-11-25', '1999-12-30',
    '1999-06-15', '1999-07-10',
    '1999-12-05', '1999-12-31', '1999-06-15', '1999-07-10', '1994-09-10',
    '1999-12-05', '1999-12-31');

-- Cadastros do usuário admin
-- Cadastro completo (1 cadastros) com datas da década de 1990 e década de 2000
INSERT INTO ListaDeCadastros (
    nome, numMatricula, IdUsuarioCadastrou, dataCadastro, dataNascimento, setor, cargo, unidade, municipio,
    dataDose1HepatiteB, dataDose2HepatiteB, dataDose3HepatiteB, dataDoseReforcoHepatiteB,
    dataExameAntiHBS, resultadoExameAntiHBS,
    dataDose1DifteriaTetano, dataDose2DifteriaTetano, dataDose3DifteriaTetano, dataDoseReforcoDifteriaTetano,
    dataDose1TripliceViral, dataDose2TripliceViral,
    dataDose1Covid, dataDose2Covid, dataDose3Covid, dataDoseReforco1Covid, dataDoseReforco2Covid,
    dataDoseUnicaFebreAmarela, dataDoseAnualInfluenza
) VALUES 
    ('Carlos Eduardo bezerra Gama', '10060', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='admin'), '1991-02-15', '1975-06-10', 
    'TI', 'Gerente', 'Sede', 'Belém',
    '2000-03-10', '1991-04-15', '1991-05-20', '2000-06-25',
    '1991-07-01', 'Positivo',
    '1991-08-05', '1991-09-10', '1991-10-15', '1991-11-20',
    '1991-12-01', '1991-12-15',
    '1991-06-01', '1991-07-05', '1991-08-10', '1991-09-15', '1991-10-20',
    '1991-11-25', '1991-12-30');

-- Cadastros do usuário padrão
-- Cadastro somente até dados do servidor (10 cadastros)
INSERT INTO ListaDeCadastros (
    nome, numMatricula, IdUsuarioCadastrou, dataCadastro, dataNascimento, setor, cargo, unidade, municipio
) VALUES 
    ('André Ferreira', '20001', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='padrao'), NOW(), '1985-07-10', 'TI', 'Suporte', 'Sede', 'São Paulo'),
    ('Bruna Costa', '20002', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='padrao'), NOW(), '1992-03-25', 'RH', 'Coordenadora', 'Filial', 'Rio de Janeiro'),
    ('Carlos Mendes', '20003', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='padrao'), NOW(), '1980-12-05', 'Financeiro', 'Analista', 'Sede', 'Belo Horizonte'),
    ('Daniela Rocha', '20004', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='padrao'), NOW(), '1995-09-15', 'Vendas', 'Executiva', 'Filial', 'Curitiba'),
    ('Eduardo Lima', '20005', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='padrao'), NOW(), '1988-06-30', 'Logística', 'Supervisor', 'Sede', 'Porto Alegre'),
    ('Fernanda Souza', '20006', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='padrao'), NOW(), '1990-04-18', 'TI', 'Programadora', 'Filial', 'Fortaleza'),
    ('Gustavo Ribeiro', '20007', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='padrao'), NOW(), '1983-11-22', 'Jurídico', 'Advogado', 'Sede', 'Salvador'),
    ('Helena Martins', '20008', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='padrao'), NOW(), '1997-02-08', 'Marketing', 'Analista', 'Filial', 'Recife'),
    ('Isabela Almeida', '20009', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='padrao'), NOW(), '1986-08-12', 'Administrativo', 'Gestora', 'Sede', 'Florianópolis'),
    ('José Augusto', '20010', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='padrao'), NOW(), '1993-05-27', 'Operacional', 'Técnico', 'Filial', 'Brasília');
-- Cadastros do usuário externo
-- Cadastro com dados de vacinação parciais (17 cadastros)
INSERT INTO ListaDeCadastros (
    nome, numMatricula, IdUsuarioCadastrou, dataCadastro, dataNascimento, setor, cargo, unidade, municipio,
    dataDose1HepatiteB, dataDose2HepatiteB, dataDose3HepatiteB, dataDoseReforcoHepatiteB,
    dataExameAntiHBS, resultadoExameAntiHBS,
    dataDose1DifteriaTetano, dataDose2DifteriaTetano, dataDose3DifteriaTetano, dataDoseReforcoDifteriaTetano,
    dataDose1TripliceViral, dataDose2TripliceViral,
    dataDose1Covid, dataDose2Covid, dataDose3Covid, dataDoseReforco1Covid, dataDoseReforco2Covid,
    dataDoseUnicaFebreAmarela, dataDoseAnualInfluenza
) VALUES 
    ('Amanda Oliveira', '30001', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='externo'), NOW(), '1990-05-15', 'Vendas', 'Representante', 'Externo', 'São Paulo', 
     '2020-01-10', NULL, NULL, NULL, 
     '2021-07-20', 'Negativo', 
     NULL, NULL, NULL, '2022-03-15', 
     NULL, '2018-09-05', 
     '2021-02-01', NULL, '2022-06-10', NULL, NULL, 
     NULL, NULL),

    ('Bruno Santos', '30002', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='externo'), NOW(), '1985-11-30', 'TI', 'Analista', 'Externo', 'Rio de Janeiro', 
     NULL, NULL, '2019-08-25', NULL, 
     '2020-12-10', 'Positivo', 
     NULL, NULL, NULL, NULL, 
     '2017-06-20', NULL, 
     NULL, NULL, '2023-05-17', NULL, '2024-01-09', 
     NULL, '2023-07-18'),

    ('Camila Rocha', '30003', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='externo'), NOW(), '1993-04-12', 'Marketing', 'Consultora', 'Externo', 'Curitiba', 
     NULL, '2021-07-01', NULL, NULL, 
     NULL, NULL, 
     '2022-09-05', NULL, NULL, NULL, 
     NULL, '2019-03-20', 
     '2021-12-12', '2022-02-22', NULL, NULL, NULL, 
     NULL, NULL),

    ('Diego Martins', '30004', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='externo'), NOW(), '1991-08-22', 'Logística', 'Coordenador', 'Externo', 'Salvador', 
     NULL, NULL, NULL, NULL, 
     '2021-10-15', 'Negativo', 
     '2018-04-30', NULL, NULL, NULL, 
     NULL, NULL, 
     NULL, NULL, '2022-09-10', NULL, NULL, 
     '2023-08-29', NULL),

    ('Eduarda Nascimento', '30005', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='externo'), NOW(), '1996-12-05', 'Recursos Humanos', 'Assistente', 'Externo', 'Brasília', 
     '2020-02-12', NULL, NULL, '2023-06-20', 
     NULL, NULL, 
     NULL, NULL, NULL, NULL, 
     '2021-11-25', NULL, 
     NULL, NULL, NULL, '2023-04-15', NULL, 
     NULL, NULL),

    ('Felipe Almeida', '30006', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='externo'), NOW(), '1994-03-08', 'Financeiro', 'Auditor', 'Externo', 'Fortaleza', 
     NULL, NULL, '2017-07-30', NULL, 
     '2019-06-01', 'Positivo', 
     '2021-05-25', NULL, NULL, '2022-12-05', 
     NULL, NULL, 
     '2020-11-01', NULL, NULL, NULL, NULL, 
     NULL, '2023-02-14'),

    ('Gabriela Lima', '30007', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='externo'), NOW(), '1989-06-17', 'TI', 'Desenvolvedora', 'Externo', 'Recife', 
     '2018-09-09', NULL, NULL, NULL, 
     '2020-04-10', 'Negativo', 
     NULL, NULL, NULL, '2021-07-30', 
     '2019-01-01', NULL, 
     NULL, NULL, NULL, '2022-06-14', NULL, 
     NULL, '2024-01-01'),

    ('Henrique Souza', '30008', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='externo'), NOW(), '1992-10-05', 'Operacional', 'Técnico', 'Externo', 'Belo Horizonte', 
     NULL, NULL, NULL, NULL, 
     '2021-02-17', 'Positivo', 
     NULL, NULL, NULL, NULL, 
     NULL, NULL, 
     NULL, NULL, NULL, NULL, NULL, 
     NULL, NULL),

    ('Isabela Castro', '30009', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='externo'), NOW(), '1997-01-25', 'Administração', 'Supervisora', 'Externo', 'Porto Alegre', 
     NULL, '2018-06-06', NULL, NULL, 
     NULL, NULL, 
     '2021-08-14', NULL, NULL, NULL, 
     NULL, '2022-03-10', 
     '2020-10-20', NULL, NULL, NULL, '2023-07-07', 
     NULL, NULL),

    ('João Pedro Vieira', '30010', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='externo'), NOW(), '1995-09-12', 'Engenharia', 'Engenheiro', 'Externo', 'Belém', 
     NULL, NULL, NULL, NULL, 
     NULL, NULL, 
     NULL, NULL, NULL, NULL, 
     '2018-05-15', NULL, 
     '2021-04-11', '2022-01-09', NULL, NULL, NULL, 
     NULL, '2023-12-30'),

    ('Karen Dias', '30011', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='externo'), NOW(), '1987-07-14', 'Comercial', 'Gerente', 'Externo', 'Florianópolis', 
     NULL, NULL, NULL, NULL, 
     '2019-11-08', 'Negativo', 
     '2020-09-29', NULL, NULL, NULL, 
     NULL, NULL, 
     NULL, NULL, '2022-08-21', NULL, NULL, 
     NULL, NULL),

    ('Lucas Ramos', '30012', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='externo'), NOW(), '1998-02-27', 'Atendimento', 'Analista', 'Externo', 'Manaus', 
     '2020-03-18', NULL, NULL, NULL, 
     NULL, NULL, 
     '2019-12-15', NULL, NULL, NULL, 
     NULL, NULL, 
     '2021-10-17', '2022-05-01', NULL, NULL, NULL, 
     NULL, NULL),

    ('Mariana Ferreira', '30013', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='externo'), NOW(), '1993-10-22', 'Marketing', 'Analista', 'Externo', 'Campinas', 
     NULL, NULL, NULL, NULL, 
     '2020-06-15', 'Positivo', 
     '2018-09-10', NULL, NULL, NULL, 
     '2021-01-12', NULL, 
     '2020-12-05', NULL, NULL, NULL, NULL, 
     NULL, NULL),

    ('Rodrigo Almeida', '30014', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='externo'), NOW(), '1990-04-08', 'TI', 'Suporte', 'Externo', 'Natal', 
     NULL, '2019-03-22', NULL, NULL, 
     NULL, NULL, 
     NULL, NULL, '2021-08-19', NULL, 
     NULL, '2022-07-14', 
     NULL, NULL, '2023-11-20', NULL, '2024-02-15', 
     NULL, NULL),

    ('Vanessa Souza', '30015', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='externo'), NOW(), '1995-12-30', 'Recursos Humanos', 'Supervisora', 'Externo', 'João Pessoa', 
     '2020-02-18', NULL, NULL, '2023-05-11', 
     NULL, NULL, 
     NULL, NULL, NULL, NULL, 
     NULL, NULL, 
     '2021-09-09', NULL, NULL, NULL, NULL, 
     NULL, '2023-07-22'),

    ('Ricardo Mendes', '30016', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='externo'), NOW(), '1988-06-03', 'Logística', 'Coordenador', 'Externo', 'Teresina', 
     NULL, NULL, '2017-12-21', NULL, 
     '2019-10-10', 'Negativo', 
     NULL, NULL, NULL, '2022-01-05', 
     '2020-11-25', NULL, 
     NULL, NULL, '2023-05-30', NULL, NULL, 
     NULL, NULL),

    ('Bianca Oliveira', '30017', (SELECT idUsuario FROM ListaDeUsuarios WHERE login='externo'), NOW(), '1997-08-19', 'Atendimento', 'Assistente', 'Externo', 'Goiânia', 
     NULL, '2018-09-17', NULL, NULL, 
     '2021-07-13', 'Positivo', 
     NULL, NULL, NULL, NULL, 
     NULL, NULL, 
     '2020-10-21', NULL, '2022-03-07', NULL, NULL, 
     NULL, '2024-01-10');