/* * * * * * * * * * * * * * * * * * * * * * * * * * */
/* Gerenciamento de consultório médico/odontológico  */
/*       Desenvolvido por: Reinaldo Silveira         */
/* * * * * * * * * * * * * * * * * * * * * * * * * * */

DROP DATABASE IF EXISTS db_consultorio;
CREATE DATABASE IF NOT EXISTS db_consultorio CHARACTER SET utf8 COLLATE utf8_general_ci;
USE db_consultorio;


CREATE TABLE TBAGENDA (
  AGENDA_ID int NOT NULL AUTO_INCREMENT,
  DATA datetime NOT NULL,
  DENTISTA_ID int NOT NULL,
  PACIENTE_ID int NOT NULL,
  SALA_ID int NOT NULL,
  OBSERVACAO varchar(500),
  TIPOCONSULTA_ID INT,
  HORARIO TIME,
  CANCELADA CHAR(1) NOT NULL DEFAULT 'N',
  constraint PK_TBAGENDA PRIMARY KEY (AGENDA_ID)   
) ENGINE=InnoDB;

CREATE TABLE TBCIDADES (
  CIDADE_ID int NOT NULL AUTO_INCREMENT,
  NOME varchar(80) NOT NULL,
  SIGLA_UF char(2) NOT NULL,
  constraint PK_TBCIDADES PRIMARY KEY (CIDADE_ID)
) ENGINE=InnoDB;

CREATE TABLE TBCONSULTA (
  CONSULTA_ID int NOT NULL AUTO_INCREMENT,
  DATA datetime NOT NULL,
  DENTISTA_ID int NOT NULL,
  PACIENTE_ID int NOT NULL,
  SALA_ID int NOT NULL,
  OBSERVACAO VARCHAR(500),
  TIPOCONSULTA_ID INT,
  HORARIO TIME,  
  constraint PK_TBCONSULTA PRIMARY KEY (CONSULTA_ID)
) ENGINE=InnoDB;

CREATE TABLE TBCONSULTA_MATERIAIS (
  CONSULTAMAT_ID int NOT NULL AUTO_INCREMENT,
  CONSULTA_ID int NOT NULL,
  MATERIAL_ID int NOT NULL,
  QUANTIDADE decimal(15,2) NOT NULL,
  constraint PK_TBCONSULTA_MATERIAIS PRIMARY KEY (CONSULTAMAT_ID)
) ENGINE=InnoDB;

CREATE TABLE TBCONSULTA_SERVICOS (
  CONSULTASRV_ID int NOT NULL AUTO_INCREMENT,
  CONSULTA_ID int NOT NULL,
  SERVICO_ID int NOT NULL,
  QUANTIDADE int NOT NULL,
  constraint PK_TBCONSULTA_SERVICOS PRIMARY KEY (CONSULTASRV_ID)
) ENGINE=InnoDB;

CREATE TABLE TBCONTASRECEBER (
  CONTA_ID int NOT NULL AUTO_INCREMENT,
  PACIENTE_ID int NOT NULL,
  DT_EMISSAO datetime NOT NULL,
  DT_VENCIMENTO datetime NOT NULL,
  DT_BAIXA datetime,
  VALOR decimal(15,2) NOT NULL DEFAULT 0,
  JUROS decimal(15,2) DEFAULT 0,
  DESCONTO decimal(15,2) DEFAULT 0,
  VALOR_PAGO decimal(15,2) DEFAULT 0,
  constraint PK_TBCONTASRECEBER PRIMARY KEY (CONTA_ID)
) ENGINE=InnoDB;

CREATE TABLE TBESTADOS (
  SIGLA_UF char(2) NOT NULL,
  NOME varchar(60) NOT NULL,
  constraint PK_TBESTADOS PRIMARY KEY (SIGLA_UF)
) ENGINE=InnoDB;

CREATE TABLE TBMATERIAIS (
  MATERIAL_ID int NOT NULL AUTO_INCREMENT,
  DESCRICAO varchar(60) NOT NULL,
  SALDO_ATUAL decimal(15,2) NOT NULL,
  SALDO_MIN decimal(15,2) NOT NULL,
  VALOR decimal(15,2) NOT NULL,
  constraint PK_TBMATERIAIS PRIMARY KEY (MATERIAL_ID)
) ENGINE=InnoDB;

CREATE TABLE TBMOVESTOQUE (
  MOVESTOQUE_ID int NOT NULL AUTO_INCREMENT,
  DATA datetime,
  MATERIAL_ID int,
  QUANTIDADE decimal(15,2),
  TIPO char(1)  COMMENT 'E - Entrada; S - Saída',
  PESSOA_ID int,
  constraint PK_TBMOVESTOQUE PRIMARY KEY (MOVESTOQUE_ID)
) ENGINE=InnoDB;

CREATE TABLE TBPESSOA (
  PESSOA_ID int NOT NULL AUTO_INCREMENT,
  NOME varchar(80) NOT NULL,
  ENDERECO varchar(100),
  BAIRRO varchar(60),
  CEP varchar(10),
  CIDADE_ID int,
  TELEFONE varchar(14),
  CELULAR varchar(14),
  EMAIL varchar(80),
  LOGIN varchar(30),
  SENHA varchar(50),
  NIVEL int NOT NULL COMMENT '1 - Administrador;  2 - Operador;  3 - Usuário.',
  ULTIMO_ACESSO datetime,
  ATIVO char(1) NOT NULL DEFAULT 'S' COMMENT 'S - Sim / N -  Não',
  CPF varchar(14),
  DT_NASCIMENTO date,
  SEXO char(1) DEFAULT 'M' COMMENT 'M - Masculino / F - Feminino',
  DT_CADASTRO datetime,
  constraint PK_TBPESSOA PRIMARY KEY (PESSOA_ID)
) ENGINE=InnoDB;

INSERT INTO TBPESSOA (NOME, LOGIN, SENHA, NIVEL, ATIVO, SEXO) 
VALUES('Administrador', 'admin', MD5('admin'), 1, 'S', 'M');

CREATE TABLE TBSALASATENDIMENTO (
  SALA_ID int NOT NULL AUTO_INCREMENT,
  DESCRICAO varchar(50) NOT NULL,
  constraint PK_TBSALASATENDIMENTO PRIMARY KEY (SALA_ID)
) ENGINE=InnoDB;

CREATE TABLE TBSERVICOS (
  SERVICO_ID int NOT NULL AUTO_INCREMENT,
  DESCRICAO varchar(100) NOT NULL,
  VALOR decimal(15,2) NOT NULL,
  TIPOTRATAMENTO_ID int,
  constraint PK_TBSERVICOS PRIMARY KEY (SERVICO_ID)
) ENGINE=InnoDB;

CREATE TABLE TBTIPOCONSULTA (
   TIPOCONSULTA_ID int not null AUTO_INCREMENT,
   DESCRICAO varchar(80) not null,
   VALOR numeric(15,4),
   constraint PK_TBTIPOCONSULTA primary key clustered (TIPOCONSULTA_ID)
) ENGINE=InnoDB;

CREATE TABLE TBTIPOTRATAMENTO (
   TIPOTRATAMENTO_ID int not null AUTO_INCREMENT,
   DESCRICAO varchar(80) not null,
   constraint PK_TBTIPOTRATAMENTO primary key clustered (TIPOTRATAMENTO_ID)
) ENGINE=InnoDB;



ALTER TABLE tbAgenda add constraint FK_tbAgenda_Sala foreign key ( SALA_ID ) references tbSalasAtendimento ( SALA_ID ) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE tbAgenda add constraint FK_tbAgenda_Dentista foreign key ( DENTISTA_ID ) references tbPessoa ( PESSOA_ID ) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE tbAgenda add constraint FK_tbAgenda_Paciente foreign key ( PACIENTE_ID ) references tbPessoa ( PESSOA_ID ) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE tbAgenda add constraint FK_tbAgenda_TipoConsulta foreign key ( TIPOCONSULTA_ID ) references tbTipoConsulta ( TIPOCONSULTA_ID ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE tbCidades add constraint FK_tbCidades_Estado foreign key ( SIGLA_UF ) references tbEstados ( SIGLA_UF ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE tbConsulta add constraint FK_tbConsulta_SalasAtendimento foreign key ( SALA_ID ) references tbSalasAtendimento ( SALA_ID ) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE tbConsulta add constraint FK_tbConsulta_TipoConsulta foreign key ( TIPOCONSULTA_ID ) references tbTipoConsulta ( TIPOCONSULTA_ID ) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE tbConsulta add constraint FK_tbConsulta_Dentista foreign key ( DENTISTA_ID ) references tbPessoa ( PESSOA_ID ) ON DELETE NO ACTION ON UPDATE NO ACTION;
ALTER TABLE tbConsulta add constraint FK_tbConsulta_Paciente foreign key ( PACIENTE_ID ) references tbPessoa ( PESSOA_ID ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE tbConsulta_materiais add constraint FK_tbConsMateriais_Consulta foreign key ( CONSULTA_ID ) references tbConsulta ( CONSULTA_ID ) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE tbConsulta_materiais add constraint FK_tbConsMateriais_Material foreign key ( MATERIAL_ID ) references tbMateriais ( MATERIAL_ID ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE tbConsulta_servicos add constraint FK_tbConsServicos_Consulta foreign key ( CONSULTA_ID ) references tbConsulta ( CONSULTA_ID ) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE tbConsulta_servicos add constraint FK_tbConsServicos_Servico foreign key ( SERVICO_ID ) references tbServicos ( SERVICO_ID ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE tbContasReceber add constraint FK_tbContasReceber_Pessoa foreign key ( PACIENTE_ID ) references tbPessoa ( PESSOA_ID ) ON DELETE NO ACTION ON UPDATE NO ACTION;
  
ALTER TABLE tbMovEstoque add constraint FK_tbMovEstoque_Material foreign key ( MATERIAL_ID ) references tbMateriais ( MATERIAL_ID ) ON DELETE NO ACTION ON UPDATE NO ACTION;
  
ALTER TABLE tbPessoa add constraint FK_tbPessoa_Cidade foreign key ( CIDADE_ID ) references tbCidades ( CIDADE_ID ) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE tbServicos add constraint FK_tbServicos_TripoTratamento foreign key ( TIPOTRATAMENTO_ID ) references tbTipoTratamento ( TIPOTRATAMENTO_ID ) ON DELETE NO ACTION ON UPDATE NO ACTION;

