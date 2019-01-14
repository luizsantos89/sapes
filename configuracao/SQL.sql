DROP DATABASE sapes;

CREATE DATABASE sapes;

USE sapes;

CREATE TABLE tipo_sancao(
    idTipo INT PRIMARY KEY AUTO_INCREMENT,
    idUsuario INT,
    dataCadastro TIMESTAMP,
    descricao VARCHAR(50),
    peso INT
);

CREATE TABLE sancao(
    idSancao INT PRIMARY KEY AUTO_INCREMENT,
    idFuncionario INT,
    idUsuario INT,
    idTipo INT,
    numDoc VARCHAR(50),
    qtdDias INT,
    motivo VARCHAR(1000),
    dataSancao TIMESTAMP,
    dataLancamento TIMESTAMP
);

CREATE TABLE gerencia(
    idGerencia INT PRIMARY KEY AUTO_INCREMENT,
    descricao VARCHAR(50)
);

CREATE TABLE divisao(
    idDivisao INT PRIMARY KEY AUTO_INCREMENT,
    idGerencia INT,
    descricao VARCHAR(50)
);

CREATE TABLE secao(
    idSecao INT PRIMARY KEY AUTO_INCREMENT,
    idDivisao INT,
    descricao VARCHAR(50)
);

CREATE TABLE funcionario(
    idFuncionario INT PRIMARY KEY AUTO_INCREMENT,
    idUsuario INT,
    idSecao INT,
    nome VARCHAR(1000),
    cargo VARCHAR(1000),
    situacao VARCHAR(500),
    dataAdmissao TIMESTAMP,
    cracha INT,
    dataCadastro TIMESTAMP,
    funcAtivo BOOLEAN,
    dataInativacao TIMESTAMP,
    cargaHoraria INT
);

CREATE TABLE desempenho(
    idDesempenho INT PRIMARY KEY AUTO_INCREMENT,
    idFuncionario INT,
    idUsuario INT,
    nota FLOAT,
    semestre INT,
    ano INT,
    dataLancamento TIMESTAMP
);

CREATE TABLE absenteismo(
    idAbsenteismo INT PRIMARY KEY AUTO_INCREMENT,
    idFuncionario INT,
    idUsuario INT,
    qtdHoras FLOAT,
    mes INT,
    ano INT,
    dataLancamento TIMESTAMP
);

CREATE TABLE usuario(
    idUsuario INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(500),
    login VARCHAR(50),
    senha VARCHAR(1000),
    ultimoAcesso TIMESTAMP
);

CREATE TABLE aproveitamento(
    idAproveitamento INT PRIMARY KEY AUTO_INCREMENT,
    idUsuario INT,
    idFuncionario INT,
    semestre INT,
    ano INT,
    horasAbsenteismo FLOAT,
    maxHorasAbsenteismo FLOAT,
    maxFatorDisciplinar FLOAT,
    pesoDesempenho FLOAT,
    pesoAbsenteismo FLOAT,
    pesoFatorDisciplinar FLOAT,
    fatorDisciplinar FLOAT,
    indiceDesempenho FLOAT,
    indiceCargaHoraria FLOAT,
    indiceAbsenteismo FLOAT,
    indiceDisciplinar FLOAT,
    indiceAproveitamento FLOAT,
    dataLancamento TIMESTAMP
);


INSERT INTO gerencia(descricao) VALUES ('GEAF');
INSERT INTO gerencia(descricao) VALUES ('GIND');

INSERT INTO divisao(descricao, idGerencia) VALUES('DVADM',1);
INSERT INTO divisao(descricao, idGerencia) VALUES('DVRH',1);
INSERT INTO divisao(descricao, idGerencia) VALUES('DVAP',1);
INSERT INTO divisao(descricao, idGerencia) VALUES('SCONF',1);
INSERT INTO divisao(descricao, idGerencia) VALUES('AGI',1);
INSERT INTO divisao(descricao, idGerencia) VALUES('APGCI',1);
INSERT INTO divisao(descricao, idGerencia) VALUES('DVENG',2);
INSERT INTO divisao(descricao, idGerencia) VALUES('DVPCP',2);
INSERT INTO divisao(descricao, idGerencia) VALUES('DVQN',2);
INSERT INTO divisao(descricao, idGerencia) VALUES('DVAPRO',2);
INSERT INTO divisao(descricao, idGerencia) VALUES('DVPRO',2);
INSERT INTO divisao(descricao, idGerencia) VALUES('SEMER',2);
INSERT INTO divisao(descricao, idGerencia) VALUES('AUXCHFJF',1);
INSERT INTO divisao(descricao, idGerencia) VALUES('OD',1);
INSERT INTO divisao(descricao, idGerencia) VALUES('AUXGEAF',1);

INSERT INTO divisao(descricao, idGerencia) VALUES('GEAF',1);
INSERT INTO divisao(descricao, idGerencia) VALUES('GIND',2);

INSERT INTO secao(descricao, idDivisao) VALUES('SALC',1);
INSERT INTO secao(descricao, idDivisao) VALUES('SEALMOX',1);
INSERT INTO secao(descricao, idDivisao) VALUES('SEPAT/CONT', 1);
INSERT INTO secao(descricao, idDivisao) VALUES('SEFIN',1);

INSERT INTO secao(descricao, idDivisao) VALUES('SAPES',2);
INSERT INTO secao(descricao, idDivisao) VALUES('SEPP',2);
INSERT INTO secao(descricao, idDivisao) VALUES('SESMT',2);
INSERT INTO secao(descricao, idDivisao) VALUES('SEMA',2);

INSERT INTO secao(descricao, idDivisao) VALUES('SETRNP/MNT',3);
INSERT INTO secao(descricao, idDivisao) VALUES('SESEG',3);
INSERT INTO secao(descricao, idDivisao) VALUES('SEPAL',3);
INSERT INTO secao(descricao, idDivisao) VALUES('SETI',3);

INSERT INTO secao(descricao, idDivisao) VALUES('O Lig',6);

INSERT INTO secao(descricao, idDivisao) VALUES('SEPD',7);
INSERT INTO secao(descricao, idDivisao) VALUES('SEPRC',7);
INSERT INTO secao(descricao, idDivisao) VALUES('SEFER',7);

INSERT INTO secao(descricao, idDivisao) VALUES('SECP',8);
INSERT INTO secao(descricao, idDivisao) VALUES('SEPLJ',8);
INSERT INTO secao(descricao, idDivisao) VALUES('SEMAT',8);
INSERT INTO secao(descricao, idDivisao) VALUES('SECCI',8);

INSERT INTO secao(descricao, idDivisao) VALUES('SEPRAD',9);
INSERT INTO secao(descricao, idDivisao) VALUES('SEQN',9);
INSERT INTO secao(descricao, idDivisao) VALUES('SEGQ',9);

INSERT INTO secao(descricao, idDivisao) VALUES('SEME', 10);
INSERT INTO secao(descricao, idDivisao) VALUES('SEMM', 10);

INSERT INTO secao(descricao, idDivisao) VALUES('SETC',11);
INSERT INTO secao(descricao, idDivisao) VALUES('SEPM',11);
INSERT INTO secao(descricao, idDivisao) VALUES('SEMG',11);

INSERT INTO secao(descricao, idDivisao) VALUES('SCONF',4);
INSERT INTO secao(descricao, idDivisao) VALUES('AGI',5);
INSERT INTO secao(descricao, idDivisao) VALUES('APGCI',6);
INSERT INTO secao(descricao, idDivisao) VALUES('SEMER',12);
INSERT INTO secao(descricao, idDivisao) VALUES('AUXCHFJF',13);
INSERT INTO secao(descricao, idDivisao) VALUES('OD',14);
INSERT INTO secao(descricao, idDivisao) VALUES('AUXGEAF',15);


INSERT INTO secao(descricao, idDivisao) VALUES('DVADM',1);
INSERT INTO secao(descricao, idDivisao) VALUES('DVRH',2);
INSERT INTO secao(descricao, idDivisao) VALUES('DVAP',3);
INSERT INTO secao(descricao, idDivisao) VALUES('DVENG',7);
INSERT INTO secao(descricao, idDivisao) VALUES('DVPCP',8);
INSERT INTO secao(descricao, idDivisao) VALUES('DVQN',9);
INSERT INTO secao(descricao, idDivisao) VALUES('DVPRO',11);
INSERT INTO secao(descricao, idDivisao) VALUES('DVAPRO',10);

INSERT INTO secao(descricao, idDivisao) VALUES('GIND',17);
INSERT INTO secao(descricao, idDivisao) VALUES('GEAF',16);


INSERT INTO tipo_sancao(idUsuario, descricao, peso, dataCadastro) VALUES (1,'Advertencia verbal',1, CURRENT_TIME);
INSERT INTO tipo_sancao(idUsuario, descricao, peso, dataCadastro) VALUES (1,'Advertencia por escrito',2, CURRENT_TIME);
INSERT INTO tipo_sancao(idUsuario, descricao, peso, dataCadastro) VALUES (1,'Suspensao',3, CURRENT_TIME);

INSERT INTO funcionario(nome,cracha,dataCadastro,dataAdmissao, cargo,funcAtivo, idUsuario, idSecao, situacao, cargaHoraria) VALUES('Luiz Claudio Afonso dos Santos',739,CURRENT_TIME,'2018-02-19','Tec Adm Especializado',true,1,12,'EC',44);

INSERT INTO usuario(nome,login,senha, ultimoAcesso) VALUES ('Administrador','admin',md5('123456'),CURRENT_TIME);

INSERT INTO sancao(idFuncionario,idUsuario,idTipo,numDoc,qtdDias,motivo,dataSancao,dataLancamento) VALUES(1,1,1,'A-001',0,'Teste','2018-12-01',CURRENT_TIME);

INSERT INTO desempenho(idFuncionario,idUsuario,nota,semestre,ano,dataLancamento) VALUES(1,1,10,1,2018,CURRENT_TIME);