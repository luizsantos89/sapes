DROP DATABASE sapes;

CREATE DATABASE sapes;

USE sapes;

CREATE TABLE tipo_sancao(
    idTipo INT PRIMARY KEY AUTO_INCREMENT,
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

CREATE TABLE funcionario(
    idFuncionario INT PRIMARY KEY AUTO_INCREMENT,
    idUsuario INT,
    nome VARCHAR(1000),
    cracha INT,
    dataCadastro TIMESTAMP,
    funcAtivo BOOLEAN
);

CREATE TABLE nota_desempenho(
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
    qtdeHoras FLOAT,
    mes INT,
    ano INT
);

CREATE TABLE usuario(
    idUsuario INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(500),
    login VARCHAR(50),
    senha VARCHAR(1000),
    ultimoAcesso TIMESTAMP
);

INSERT INTO tipo_sancao(descricao, peso) VALUES ('Advertência verbal',1);
INSERT INTO tipo_sancao(descricao, peso) VALUES ('Notificação por escrito',1);
INSERT INTO tipo_sancao(descricao, peso) VALUES ('Advertência por escrito',2);
INSERT INTO tipo_sancao(descricao, peso) VALUES ('Suspensão',3);

INSERT INTO funcionario(nome,cracha,dataCadastro,funcAtivo, idUsuario) VALUES('Luiz Cláudio Afonso dos Santos',739,CURRENT_TIME,true,1);

INSERT INTO usuario(nome,login,senha, ultimoAcesso) VALUES ('Rosana','rosana',md5('123456'),CURRENT_TIME);

INSERT INTO sancao(idFuncionario,idUsuario,idTipo,numDoc,qtdDias,motivo,dataSancao,dataLancamento) VALUES(1,1,1,'A-001',0,'Teste','2018-12-01',CURRENT_TIME);

INSERT INTO nota_desempenho(idFuncionario,idUsuario,nota,semestre,ano,dataLancamento) VALUES(1,1,10,1,2018,CURRENT_TIME);