-- ------------------------------------------------------------
-- Tabela das Regiões/Áreas para envio de E-Mkt
-- ------------------------------------------------------------

CREATE TABLE regiao (
  reg_id INT(11)  NOT NULL   AUTO_INCREMENT COMMENT 'ID da Regiao' ,
  reg_nome VARCHAR(100)  NOT NULL   COMMENT 'Nome da Regiao' ,
  reg_nivel TINYINT(3)  NULL   COMMENT 'Nivel da Regiao' ,
  reg_status TINYINT(3)  NOT NULL   COMMENT 'Status da Regiao: 1 - ATIVO, 2 - INATIVO'   ,
PRIMARY KEY(reg_id)  ,
UNIQUE INDEX Index_1(reg_nome))
TYPE=InnoDB
COMMENT = 'Tabela das Regiões/Áreas para envio de E-Mkt' ;








-- ------------------------------------------------------------
-- Tabela contendo os Usuários que acessam o sistema.
-- ------------------------------------------------------------

CREATE TABLE usuario (
  usr_id INT(11)  NOT NULL   AUTO_INCREMENT COMMENT 'ID do Usuário' ,
  usr_login_id VARCHAR(15)  NOT NULL   COMMENT 'Id de Login do Usuário para acesso ao sistema' ,
  usr_pass VARCHAR(50)  NOT NULL   COMMENT 'Senha para acesso ao sistema' ,
  usr_nome VARCHAR(100)  NULL   COMMENT 'Nome do Usuário' ,
  usr_sobrenome VARCHAR(30)  NULL   COMMENT 'Sobrenome do Usuário - SOMENTE ULTIMO NOME' ,
  usr_apelido VARCHAR(20)  NULL   COMMENT 'Apelido do Usuário' ,
  usr_email VARCHAR(100)  NOT NULL   COMMENT 'Endereço de email do Usuário para cominicação.' ,
  usr_telefone VARCHAR(15)  NULL   COMMENT 'Telefone para contato do Usuário' ,
  usr_sexo TINYINT(3) UNSIGNED  NULL   COMMENT 'Sexo do Usuário' ,
  usr_data_cadastro TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT 'Data de cadastro do Usuário no Sistema' ,
  usr_nivel TINYINT(3) UNSIGNED  NULL   COMMENT 'Nível do Usuário' ,
  usr_status TINYINT(3) UNSIGNED  NOT NULL   COMMENT 'Status do email: ATIVO / INATIVO'   ,
PRIMARY KEY(usr_id)  ,
UNIQUE INDEX Index_1(usr_login_id))
TYPE=InnoDB
COMMENT = 'Tabela contendo os Usuários que acessam o sistema.' ;
















-- ------------------------------------------------------------
-- Tabela contendo nome/descricao dos níveis dos Emails
-- ------------------------------------------------------------

CREATE TABLE nivel (
  lvl_id INT(11)  NOT NULL   COMMENT 'ID do Nivel' ,
  lvl_nome VARCHAR(20)  NOT NULL   COMMENT 'Nome/Descricao do nivel' ,
  lvl_status TINYINT(3)  NOT NULL   COMMENT 'Status do Nivel: 1 - ATIVO , 2 - INATIVO'   ,
PRIMARY KEY(lvl_id)  ,
UNIQUE INDEX Index_1(lvl_nome))
TYPE=InnoDB
COMMENT = 'Tabela contendo nome/descricao dos níveis dos Emails' ;







-- ------------------------------------------------------------
-- Tabela contendo os Templates para envio de E-Marketing.
-- ------------------------------------------------------------

CREATE TABLE template (
  tpl_id INT(11)  NOT NULL   AUTO_INCREMENT COMMENT 'ID do Template' ,
  tpl_usr_id INT(11)  NOT NULL  ,
  tpl_nome VARCHAR(100)  NULL   COMMENT 'Nome de exibição do Template' ,
  tpl_arquivo VARCHAR(50)  NOT NULL   COMMENT 'Nome do Arquivo Template' ,
  tpl_img_url VARCHAR(200)  NOT NULL   COMMENT 'Endereço URL das imagens no Arquivo Template' ,
  tpl_msg_padrao TEXT  NULL   COMMENT 'Mensagem padrão do Template' ,
  tpl_data_cadastro TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT 'Data de cadastro do Template no sistema.' ,
  tpl_status TINYINT(3) UNSIGNED  NOT NULL   COMMENT 'Status do email: ATIVO / INATIVO'   ,
PRIMARY KEY(tpl_id, tpl_usr_id)  ,
UNIQUE INDEX Index_1(tpl_arquivo)  ,
INDEX template_FKIndex1(tpl_usr_id),
  FOREIGN KEY(tpl_usr_id)
    REFERENCES usuario(usr_id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION)
TYPE=InnoDB
COMMENT = 'Tabela contendo os Templates para envio de E-Marketing.' ;









CREATE INDEX IFK_Rel_03 ON template (tpl_usr_id);


-- ------------------------------------------------------------
-- Tabela com a lista de emails para enviar E-Mkt
-- ------------------------------------------------------------

CREATE TABLE lista_email (
  lst_id INT(11)  NOT NULL   AUTO_INCREMENT COMMENT 'ID do email' ,
  lst_usr_id INT(11)  NULL  ,
  lst_email VARCHAR(100)  NOT NULL   COMMENT 'Endereco de email da pessoa' ,
  lst_nome_tratamento VARCHAR(50)  NULL   COMMENT 'Nome de tratamento da pessoa, ex. Sr., Dr., Caro,...' ,
  lst_primeiro_nome VARCHAR(50)  NULL   COMMENT 'Primeiro nome da pessoa' ,
  lst_nome_meio VARCHAR(100)  NULL   COMMENT 'Nome do meio da pessoa' ,
  lst_sobrenome VARCHAR(15)  NULL   COMMENT 'Sobrenome da pessoa' ,
  lst_sexo TINYINT(3) UNSIGNED  NULL   COMMENT 'Genero Sexual da Pessoa: 1 - Masculino, 2 - Feminino, 3 - Nao Informado' ,
  lst_data_cadastro TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT 'Data de cadastro do Email no sistema.' ,
  lst_nivel TINYINT(3)  NULL   COMMENT 'Nível do email ex. 1- , 2- ,3- , ........ , 27-Master' ,
  lst_status TINYINT(3)  NOT NULL   COMMENT 'Status do email: ATIVO / INATIVO'   ,
PRIMARY KEY(lst_id)  ,
UNIQUE INDEX Index_1(lst_email)  ,
INDEX lista_email_FKIndex1(lst_usr_id),
  FOREIGN KEY(lst_usr_id)
    REFERENCES usuario(usr_id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION)
TYPE=InnoDB
COMMENT = 'Tabela com a lista de emails para enviar E-Mkt' ;












CREATE INDEX IFK_Rel_05 ON lista_email (lst_usr_id);


-- ------------------------------------------------------------
-- Relacao entre Emails para envio de E-Mkt e a Regiao de envio
-- ------------------------------------------------------------

CREATE TABLE email_regiao (
  lst_id INT(11)  NOT NULL  ,
  reg_id INT(11)  NOT NULL    ,
PRIMARY KEY(lst_id, reg_id)  ,
INDEX email_regiao_FKIndex1(lst_id)  ,
INDEX email_regiao_FKIndex2(reg_id),
  FOREIGN KEY(lst_id)
    REFERENCES lista_email(lst_id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(reg_id)
    REFERENCES regiao(reg_id)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION)
TYPE=InnoDB
COMMENT = 'Relacao entre Emails para envio de E-Mkt e a Regiao de envio' ;


CREATE INDEX IFK_Rel_01 ON email_regiao (lst_id);
CREATE INDEX IFK_Rel_02 ON email_regiao (reg_id);



