#Criação do Banco de dados, denominados compras
create database compras;

#Habilitamos a ultilização do banco de dados
use compras;

#Estrutura da tabela usúarios
create table usuarios(
	id_usuario integer not null auto_increment primary key,
    usuario varchar(15) not null,
    senha varchar(32) not null,
    dtcria datetime default now(),
    estatus char(10) default ''
);

#Vamos inserir um usúario padrão do sistema

insert into usuarios(usuario, senha)
values ('admin', md5('admin123'));

#Ao final fazemos um Select para verificar o registro inserido
Select * from usuarios where senha = md5('admin123');

use compras;
#Alterando a tabela de usuario de acordo novas necessidades, inserindo os campos nome e tipo
Alter table usuarios add column nome varchar(30) default '' after senha,
			add column tipo varchar(20) default '' after estatus;


Select * from usuarios;


#Mudando a estrutura da tabela de usuarios
Alter table usuarios drop column id_usuario;
Alter table usuarios modify usuario varchar(15) not null primary key;

desc produtos;

#Estrutura da tabela de unidade de medidas
create table unid_medida (
	cod_unidade integer auto_increment primary key,
    sigla varchar(03) default '',
    descricao varchar(30) default '',
    dtcria  datetime default now(),
    usucria varchar(15) default '',
    estatus char(01) default '',
    
    constraint foreign key fk_unidmed_prod (usucria) references usuarios(usuario)
);

#Estrutura da tabela de produtos
create table produtos(
	cod_produto integer auto_increment primary key,
    descricao varchar(30) default '',
    unid_medida integer default 0,
    estoq_minimo integer default 0,
    estoq_maximo integer default 0,
    dtcria  datetime default now(),
    usucria varchar(15) default '',
    estatus char(01) default '',
    
    constraint foreign key fk_prod_unidmed (unid_medida) references unid_medida(cod_unidade),
    constraint foreign key fk_prod_usuarios (usucria) references usuarios(usuario)
);

Select * from unid_medida;