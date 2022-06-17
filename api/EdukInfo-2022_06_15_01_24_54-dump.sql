-- MySQL dump 10.13  Distrib 8.0.29, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: edukinfo
-- ------------------------------------------------------
-- Server version	8.0.29-0ubuntu0.22.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Cursos`
--

DROP TABLE IF EXISTS `Cursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Cursos` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'ID do curso',
  `nome` varchar(50) NOT NULL COMMENT 'Nome do curso',
  `descricao` varchar(255) NOT NULL COMMENT 'Breve descrição do curso',
  `preco` decimal(6,2) NOT NULL COMMENT 'Preço do curso',
  `descontinuado` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Se o curso foi descontinuado...',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cursos_id_uindex` (`id`),
  UNIQUE KEY `cursos_nome_uindex` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Cursos em que a escola possui';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cursos`
--

LOCK TABLES `Cursos` WRITE;
/*!40000 ALTER TABLE `Cursos` DISABLE KEYS */;
INSERT INTO `Cursos` (`id`, `nome`, `descricao`, `preco`, `descontinuado`) VALUES (1,'Curso de Angular','Crie sites e aplicações Web dinâmicas e muito robusta, com uma ferramenta bem poderosa criada pelo Google.',349.98,0);
INSERT INTO `Cursos` (`id`, `nome`, `descricao`, `preco`, `descontinuado`) VALUES (2,'Curso de VueJS + Nuxt.JS','Crie sites e aplicações WEB dinâmicos com muita robustez, apenas usando JavaScript',299.65,0);
INSERT INTO `Cursos` (`id`, `nome`, `descricao`, `preco`, `descontinuado`) VALUES (3,'Curso de React + Next.JS','Crie sites e aplicações Web dinâmicas e muito robusta, com uma ferramenta bem poderosa criada pelo Facebook, em conjunto com um poderoso framework para esta ferramenta, criado pela comunide.',328.58,0);
INSERT INTO `Cursos` (`id`, `nome`, `descricao`, `preco`, `descontinuado`) VALUES (4,'Curso de Flutter','Crie aplicações para Celular, PC (ou Mac) e WEB, apenas utilizando esta ferramenta desenvolvida pelo Google. Codifique uma vez e rode em qualquer sistema, navegador ou celular. Aplicativos como o NuBank® utilizam esta tecnologia.',381.97,0);
INSERT INTO `Cursos` (`id`, `nome`, `descricao`, `preco`, `descontinuado`) VALUES (5,'Curso de Web Design completo','Crie Sites completos e páginas da web, desde a prototipagem até os designs e codificações.',629.89,0);
INSERT INTO `Cursos` (`id`, `nome`, `descricao`, `preco`, `descontinuado`) VALUES (6,'Curso de Design Gráfico','Crie artes e diagramações para divulgações diversas',524.97,0);
INSERT INTO `Cursos` (`id`, `nome`, `descricao`, `preco`, `descontinuado`) VALUES (7,'Curso de Publicidade e Propaganda','Aprenda a como usar corretamente as redes sociais e fazer divulgações',825.43,0);
INSERT INTO `Cursos` (`id`, `nome`, `descricao`, `preco`, `descontinuado`) VALUES (8,'Curso de informática básica para crianças','Aprenda a usar um computador pela primeira vez na vida desde novo',168.23,0);
INSERT INTO `Cursos` (`id`, `nome`, `descricao`, `preco`, `descontinuado`) VALUES (9,'Curso de informática básica para idosos','Aprenda a usar um computador e se modernizar por completo',165.23,0);
INSERT INTO `Cursos` (`id`, `nome`, `descricao`, `preco`, `descontinuado`) VALUES (10,'Curso de React Native','Crie aplicativos, programando apenas uma vez, para rodar em qualquer smartphone (Android e iOS), apenas utilizando o JavaScript moderno, com esta ferramenta desenvolvida pelo Facebook e usada, inclusive, no Instagram/Facebook/Discord/Uber/Etc.',385.62,1);
/*!40000 ALTER TABLE `Cursos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Endereco_usuarios`
--

DROP TABLE IF EXISTS `Endereco_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Endereco_usuarios` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID deste endereço',
  `id_usuario` int NOT NULL COMMENT 'Cliente ao qual pertence este endereço',
  `descricao` varchar(50) NOT NULL COMMENT 'Descriçao do endereço informado pelo usuario.',
  `finalidade` varchar(20) NOT NULL COMMENT 'Finalidade do endereço informado pelo cliente, caso venha a ser aplicado.',
  `endereco` varchar(200) NOT NULL COMMENT 'Endereço completo do cliente',
  `numero` int DEFAULT NULL COMMENT 'Se caso o local tiver numero, entao entra o numero.',
  `complemento` varchar(60) DEFAULT NULL COMMENT 'complemento do endereço cadastrado, caso se aplique.',
  `bairro` varchar(50) NOT NULL COMMENT 'Bairro ao qual pertence o endereço',
  `cidade` varchar(50) NOT NULL COMMENT 'Cidade do endereço cadastrado.',
  `estado` varchar(2) NOT NULL COMMENT 'Sigla do estado ao qual pertence o endereço.',
  `cep` varchar(10) NOT NULL COMMENT 'CEP do endereço informado',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Endereco_usuarios_id_uindex` (`id`),
  KEY `Endereco_usuarios_Usuarios_id_fk` (`id_usuario`),
  CONSTRAINT `Endereco_usuarios_Usuarios_id_fk` FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Todos os respectivos endereços em que o cliente/usuário cadastrou, estão aqui.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Endereco_usuarios`
-- These data are fake and generated by https://www.4devs.com.br
--

LOCK TABLES `Endereco_usuarios` WRITE;
/*!40000 ALTER TABLE `Endereco_usuarios` DISABLE KEYS */;
INSERT INTO `Endereco_usuarios` (`id`, `id_usuario`, `descricao`, `finalidade`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`) VALUES (1,19,'Endereço de casa','Tudo','Rua Ilha do Mel',770,NULL,'Chácara Santa Maria','Cambé','PR','86189060');
INSERT INTO `Endereco_usuarios` (`id`, `id_usuario`, `descricao`, `finalidade`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`) VALUES (2,20,'Minha casa','Entregas','Rua Boa Vista',496,NULL,'Portal das Colinas','Guaratinguetá','SP','12516170');
INSERT INTO `Endereco_usuarios` (`id`, `id_usuario`, `descricao`, `finalidade`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`) VALUES (3,22,'Casa','Entregas','Rua Vereador Euclides do Nascimento',325,'Na direção do 831','Povoado de Passagem da Barra','Laguna','SC','88790973');
INSERT INTO `Endereco_usuarios` (`id`, `id_usuario`, `descricao`, `finalidade`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`) VALUES (4,25,'Endereço de casa','','Rua Vitória',448,'','Jardim Colégio de Passos','Passos','MG','88790973');
INSERT INTO `Endereco_usuarios` (`id`, `id_usuario`, `descricao`, `finalidade`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`) VALUES (5,26,'Endereço de casa','','Rua Manoel Sátiro de Menezes',519,'','Industrial','Aracaju','SE','49065-560');
INSERT INTO `Endereco_usuarios` (`id`, `id_usuario`, `descricao`, `finalidade`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`) VALUES (6,27,'Endereço de casa','','Conjunto AR 13 Conjunto 3',609,'','Setor Oeste (Sobradinho II)','Brasília','DF','73062-303');
INSERT INTO `Endereco_usuarios` (`id`, `id_usuario`, `descricao`, `finalidade`, `endereco`, `numero`, `complemento`, `bairro`, `cidade`, `estado`, `cep`) VALUES (7,28,'Endereço gerado no 4devs','','Rua das Palmeiras',476,'lote 12 Quadra C','Jardim Tropical','Rio Branco','AC','69901-230');
/*!40000 ALTER TABLE `Endereco_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Fotos_unidade_interior`
--

DROP TABLE IF EXISTS `Fotos_unidade_interior`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Fotos_unidade_interior` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'id da foto',
  `id_unidade` int DEFAULT NULL COMMENT 'id da unidade ao qual se associa a foto do interior',
  `image_url` text NOT NULL COMMENT 'URL do interior da unidade',
  `image_txt` varchar(255) NOT NULL COMMENT 'Texto alternativo da imagem',
  `descricao_curta` varchar(50) NOT NULL COMMENT 'Descrição muito curta, apenas para pre-apresentar',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Fotos_unidade_interior_id_uindex` (`id`),
  KEY `Fotos_unidade_interior_Unidades_id_fk` (`id_unidade`),
  CONSTRAINT `Fotos_unidade_interior_Unidades_id_fk` FOREIGN KEY (`id_unidade`) REFERENCES `Unidades` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Fotos do interior da unidade';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Fotos_unidade_interior`
--

LOCK TABLES `Fotos_unidade_interior` WRITE;
/*!40000 ALTER TABLE `Fotos_unidade_interior` DISABLE KEYS */;
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (1,1,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localização');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (2,1,'@baseUrl%/assets/images/interior-unidades/recepcao-01.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (3,1,'@baseUrl%/assets/images/interior-unidades/sala-aula-01.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (5,2,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localização');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (6,2,'@baseUrl%/assets/images/interior-unidades/recepcao-02.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (7,2,'@baseUrl%/assets/images/interior-unidades/sala-aula-02.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (8,3,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localização');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (9,3,'@baseUrl%/assets/images/interior-unidades/recepcao-03.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (10,3,'@baseUrl%/assets/images/interior-unidades/sala-aula-03.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (11,4,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localização');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (12,4,'@baseUrl%/assets/images/interior-unidades/recepcao-01.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (13,4,'@baseUrl%/assets/images/interior-unidades/sala-aula-02.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (14,5,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localização');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (15,5,'@baseUrl%/assets/images/interior-unidades/recepcao-01.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (16,5,'@baseUrl%/assets/images/interior-unidades/sala-aula-03.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (17,6,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localização');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (18,6,'@baseUrl%/assets/images/interior-unidades/recepcao-02.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (19,6,'@baseUrl%/assets/images/interior-unidades/sala-aula-01.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (20,7,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localização');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (21,7,'@baseUrl%/assets/images/interior-unidades/recepcao-02.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (22,7,'@baseUrl%/assets/images/interior-unidades/sala-aula-03.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (23,8,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localização');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (24,8,'@baseUrl%/assets/images/interior-unidades/recepcao-03.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (25,8,'@baseUrl%/assets/images/interior-unidades/sala-aula-01.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (26,9,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localização');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (27,9,'@baseUrl%/assets/images/interior-unidades/recepcao-03.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (28,9,'@baseUrl%/assets/images/interior-unidades/sala-aula-02.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (29,10,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localizaçao');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (30,11,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localizaçao');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (31,12,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localizaçao');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (32,13,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localizaçao');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (33,14,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localizaçao');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (34,15,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localizaçao');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (35,16,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localizaçao');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (36,17,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localizaçao');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (37,18,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localizaçao');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (38,19,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localizaçao');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (39,20,'@baseUrl%/assets/images/AdobeStock_231662305.jpeg','Mapa de localização','Mapa de localizaçao');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (41,1,'@baseUrl%/assets/images/interior-unidades/lab-info-01.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (42,1,'@baseUrl%/assets/images/interior-unidades/lab-mac-01.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (43,2,'@baseUrl%/assets/images/interior-unidades/lab-info-02.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (44,2,'@baseUrl%/assets/images/interior-unidades/lab-mac-02.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (45,3,'@baseUrl%/assets/images/interior-unidades/lab-info-03.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (46,3,'@baseUrl%/assets/images/interior-unidades/lab-mac-03.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (47,4,'@baseUrl%/assets/images/interior-unidades/lab-info-01.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (48,4,'@baseUrl%/assets/images/interior-unidades/lab-mac-02.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (49,5,'@baseUrl%/assets/images/interior-unidades/lab-info-01.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (50,5,'@baseUrl%/assets/images/interior-unidades/lab-mac-03.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (51,6,'@baseUrl%/assets/images/interior-unidades/lab-info-02.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (52,6,'@baseUrl%/assets/images/interior-unidades/lab-mac-01.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (53,7,'@baseUrl%/assets/images/interior-unidades/lab-info-02.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (54,7,'@baseUrl%/assets/images/interior-unidades/lab-mac-03.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (55,8,'@baseUrl%/assets/images/interior-unidades/lab-info-03.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (56,8,'@baseUrl%/assets/images/interior-unidades/lab-mac-01.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (57,9,'@baseUrl%/assets/images/interior-unidades/lab-info-03.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (58,9,'@baseUrl%/assets/images/interior-unidades/lab-mac-02.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (59,10,'@baseUrl%/assets/images/interior-unidades/recepcao-01.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (60,10,'@baseUrl%/assets/images/interior-unidades/sala-aula-01.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (61,11,'@baseUrl%/assets/images/interior-unidades/recepcao-02.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (62,11,'@baseUrl%/assets/images/interior-unidades/sala-aula-02.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (63,12,'@baseUrl%/assets/images/interior-unidades/recepcao-03.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (64,12,'@baseUrl%/assets/images/interior-unidades/sala-aula-03.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (65,13,'@baseUrl%/assets/images/interior-unidades/recepcao-01.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (66,13,'@baseUrl%/assets/images/interior-unidades/sala-aula-02.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (67,14,'@baseUrl%/assets/images/interior-unidades/recepcao-01.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (68,14,'@baseUrl%/assets/images/interior-unidades/sala-aula-03.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (69,15,'@baseUrl%/assets/images/interior-unidades/recepcao-02.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (70,15,'@baseUrl%/assets/images/interior-unidades/sala-aula-01.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (71,16,'@baseUrl%/assets/images/interior-unidades/recepcao-02.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (72,16,'@baseUrl%/assets/images/interior-unidades/sala-aula-03.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (73,17,'@baseUrl%/assets/images/interior-unidades/recepcao-03.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (74,17,'@baseUrl%/assets/images/interior-unidades/sala-aula-01.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (75,18,'@baseUrl%/assets/images/interior-unidades/recepcao-03.jpeg','Secretatia','Secretaria desta unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (76,18,'@baseUrl%/assets/images/interior-unidades/sala-aula-02.jpeg','Sala de aula','Salas de aula da unidade');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (77,10,'@baseUrl%/assets/images/interior-unidades/lab-info-01.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (78,10,'@baseUrl%/assets/images/interior-unidades/lab-mac-01.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (79,11,'@baseUrl%/assets/images/interior-unidades/lab-info-02.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (80,11,'@baseUrl%/assets/images/interior-unidades/lab-mac-02.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (81,12,'@baseUrl%/assets/images/interior-unidades/lab-info-03.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (82,12,'@baseUrl%/assets/images/interior-unidades/lab-mac-03.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (83,13,'@baseUrl%/assets/images/interior-unidades/lab-info-01.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (84,13,'@baseUrl%/assets/images/interior-unidades/lab-mac-02.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (85,14,'@baseUrl%/assets/images/interior-unidades/lab-info-01.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (86,14,'@baseUrl%/assets/images/interior-unidades/lab-mac-03.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (87,15,'@baseUrl%/assets/images/interior-unidades/lab-info-02.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (88,15,'@baseUrl%/assets/images/interior-unidades/lab-mac-01.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (89,16,'@baseUrl%/assets/images/interior-unidades/lab-info-02.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (90,16,'@baseUrl%/assets/images/interior-unidades/lab-mac-03.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (91,17,'@baseUrl%/assets/images/interior-unidades/lab-info-03.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (92,17,'@baseUrl%/assets/images/interior-unidades/lab-mac-01.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (93,18,'@baseUrl%/assets/images/interior-unidades/lab-info-03.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (94,18,'@baseUrl%/assets/images/interior-unidades/lab-mac-02.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (95,19,'@baseUrl%/assets/images/interior-unidades/lab-mac-02.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (96,19,'@baseUrl%/assets/images/interior-unidades/lab-info-02.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (97,20,'@baseUrl%/assets/images/interior-unidades/lab-info-03.jpg','Laboratório de informática','Um dos Laboratório desta unidade.');
INSERT INTO `Fotos_unidade_interior` (`id`, `id_unidade`, `image_url`, `image_txt`, `descricao_curta`) VALUES (98,20,'@baseUrl%/assets/images/interior-unidades/lab-mac-02.jpg','Laboratório com Mac OS X','Um dos Laboratório desta unidade com Mac OS X');
/*!40000 ALTER TABLE `Fotos_unidade_interior` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Grade_materia_cursos`
--

DROP TABLE IF EXISTS `Grade_materia_cursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Grade_materia_cursos` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID da grade do curso',
  `id_materia` int NOT NULL COMMENT 'ID da relação da tabela matéria do curso, indicando a matéria do curso',
  `id_curso` int NOT NULL COMMENT 'ID do curso ao qual pertence a matéria',
  `posicao` int NOT NULL COMMENT 'Posição em que a matéria é exibida na grade...',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Grade_materia_cursos_id_uindex` (`id`),
  KEY `Grade_materia_cursos_Cursos_id_fk` (`id_curso`),
  KEY `Grade_materia_cursos_Materia_cursos_id_fk` (`id_materia`),
  CONSTRAINT `Grade_materia_cursos_Cursos_id_fk` FOREIGN KEY (`id_curso`) REFERENCES `Cursos` (`id`),
  CONSTRAINT `Grade_materia_cursos_Materia_cursos_id_fk` FOREIGN KEY (`id_materia`) REFERENCES `Materia_cursos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Grade de materia dos cursos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Grade_materia_cursos`
--

LOCK TABLES `Grade_materia_cursos` WRITE;
/*!40000 ALTER TABLE `Grade_materia_cursos` DISABLE KEYS */;
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (1,1,1,1);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (2,2,1,2);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (3,3,1,3);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (4,4,1,4);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (5,5,1,5);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (6,6,1,6);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (7,7,1,7);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (8,8,1,8);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (9,9,1,9);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (10,10,1,10);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (11,11,1,11);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (12,12,1,12);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (13,13,1,13);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (14,14,1,14);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (15,15,1,15);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (16,16,1,16);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (17,17,1,17);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (18,18,1,18);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (19,19,1,19);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (20,20,1,20);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (21,21,1,21);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (22,22,1,22);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (23,23,1,23);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (24,24,1,24);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (25,25,1,25);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (26,26,1,26);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (27,27,1,27);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (28,28,1,28);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (29,29,1,29);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (30,1,2,1);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (31,2,2,2);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (32,3,2,3);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (33,4,2,4);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (34,5,2,5);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (35,6,2,6);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (36,7,2,7);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (37,30,2,8);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (38,31,2,9);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (39,32,2,10);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (40,33,2,11);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (41,34,2,12);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (42,35,2,13);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (43,36,2,14);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (44,37,2,15);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (45,38,2,16);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (46,39,2,17);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (47,40,2,18);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (48,41,2,19);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (49,42,2,20);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (50,43,2,21);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (51,44,2,22);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (52,45,2,23);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (53,24,2,24);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (54,25,2,25);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (55,45,2,26);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (56,46,2,27);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (57,28,2,28);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (58,47,2,29);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (59,1,3,1);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (60,2,3,2);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (61,3,3,3);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (62,4,3,4);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (63,5,3,5);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (64,6,3,6);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (65,7,3,7);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (66,48,3,8);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (67,49,3,9);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (68,50,3,10);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (69,51,3,11);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (70,52,3,12);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (71,53,3,13);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (72,54,3,14);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (73,55,3,15);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (74,56,3,16);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (75,57,3,17);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (76,58,3,18);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (77,59,3,19);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (78,60,3,20);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (79,61,3,21);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (80,24,3,22);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (81,25,3,23);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (82,28,3,24);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (83,1,4,1);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (84,2,4,2);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (85,62,4,3);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (86,63,4,4);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (87,64,4,5);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (88,65,4,6);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (89,66,4,7);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (90,67,4,8);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (91,68,4,9);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (92,69,4,10);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (93,70,4,11);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (94,71,4,12);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (95,72,4,13);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (96,73,4,14);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (97,74,4,15);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (98,75,4,16);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (99,76,4,17);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (100,77,4,18);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (101,78,4,19);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (102,24,4,20);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (103,25,4,21);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (104,79,4,22);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (105,28,4,23);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (106,80,5,1);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (107,81,5,2);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (108,82,5,3);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (109,83,5,4);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (110,84,5,5);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (111,85,5,6);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (112,86,5,7);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (113,87,5,8);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (114,1,5,9);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (115,3,5,10);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (116,88,5,9);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (117,89,5,10);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (118,90,5,11);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (119,91,5,12);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (120,24,5,13);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (121,92,6,1);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (122,80,6,2);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (123,81,6,3);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (124,82,6,4);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (125,83,6,5);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (126,84,6,6);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (127,85,6,7);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (128,93,6,8);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (129,94,6,9);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (130,95,6,10);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (131,96,6,11);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (132,80,7,1);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (133,81,7,2);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (134,82,7,3);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (135,83,7,4);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (136,84,7,5);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (137,85,7,6);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (138,97,7,7);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (139,98,7,8);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (140,99,7,9);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (141,100,7,10);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (142,101,7,11);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (143,102,7,12);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (144,103,7,13);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (145,104,7,14);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (146,105,7,15);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (147,106,7,16);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (148,113,8,1);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (149,107,8,2);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (150,108,8,3);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (151,109,8,4);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (152,110,8,5);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (153,111,8,6);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (154,112,8,7);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (155,113,8,1);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (156,107,8,2);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (157,108,8,3);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (158,109,8,4);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (159,110,8,5);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (160,111,8,6);
INSERT INTO `Grade_materia_cursos` (`id`, `id_materia`, `id_curso`, `posicao`) VALUES (161,112,8,7);
/*!40000 ALTER TABLE `Grade_materia_cursos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Imagens_slide_curso`
--

DROP TABLE IF EXISTS `Imagens_slide_curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Imagens_slide_curso` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID da imagem do slide de cursos',
  `id_curso` int NOT NULL COMMENT 'ID do curso ao qual pertence a imagem',
  `url` text NOT NULL COMMENT 'URL da imagem ',
  `texto_alternativo_img` varchar(64) NOT NULL COMMENT 'Texto alternativo a ser exbido se a imagem nao carregar',
  `descricao` varchar(1023) NOT NULL COMMENT 'Breve descriçao do curso a ser exibido ao usuario',
  `posicao_imagem` int DEFAULT NULL COMMENT 'Posiçao da Imagem em que e exibido, a fila de exibiçao...',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Imagens_slide_curso_id_uindex` (`id`),
  KEY `Imagens_slide_curso_Cursos_id_fk` (`id_curso`),
  CONSTRAINT `Imagens_slide_curso_Cursos_id_fk` FOREIGN KEY (`id_curso`) REFERENCES `Cursos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Imagens dos slides de cursos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Imagens_slide_curso`
--

LOCK TABLES `Imagens_slide_curso` WRITE;
/*!40000 ALTER TABLE `Imagens_slide_curso` DISABLE KEYS */;
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (1,1,'@baseUrl%/assets/images/Angular-splash.svg','Angular','Angular, um framework de desenvolvimento de aplicações para web, desenvolvido pelo Google.',1);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (2,1,'@baseUrl%/assets/images/Angular-splash-2.svg','Angular + Angular Universal + Angular Material','Angular em conjunto com Angular Universal e Angular Material',2);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (3,1,'@baseUrl%/assets/images/html5-css3-spash.svg','HTML 5 + CSS 3','HTML 5 e CSS 3: Desenvolvendo páginas da web',3);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (4,1,'@baseUrl%/assets/images/nodejs-splash.svg','Node.JS','Node.JS: Uma ferramenta revolucionária que possibilitou rodar aplicações em JavaScript/TypeScript fora dos navegadores, tornando possível criar aplicações apenas usando JavaScript. O NodeJS, é um JavaScript \"compilado\" em modo grosseiro de se dizer.',4);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (5,1,'@baseUrl%/assets/images/sass-splash.svg','SASS','SASS: Um CSS convencional, porém com riquezas de recursos. É um CSS pré-processado e convertido para linguagem de CSS padrão de navegadores.',5);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (6,1,'@baseUrl%/assets/images/less-splash.svg','LESS','LESS: Significa Leaner Style Sheets, é uma extensão de linguagem compatível com versões anteriores para a linguagem CSS.',6);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (7,2,'@baseUrl%/assets/images/vuejs-splash.svg','Vue.JS','Vue.JS: Um framework de desenvolvimento web progressivo, desenvolvido pela comunidade para web, desenvolvido pela comunidade de projetos open-source e adotado, inclusive, pela Nintendo.',1);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (8,2,'@baseUrl%/assets/images/vuejs-splash-2.svg','Vue.JS + NuxtJS + Vuetify','Vue.JS em conjunto com NuxtJS (Um framework exclusivo para trabalhar em conjunto com Vue.JS e fazer o Server-Side Rendering) + Vuetify (Framework CSS do Material Design para Vue.JS).',2);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (9,2,'@baseUrl%/assets/images/html5-css3-spash.svg','HTML 5 + CSS 3','HTML 5 e CSS 3: Desenvolvendo páginas da web',3);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (10,2,'@baseUrl%/assets/images/nodejs-splash.svg','Node.JS','Node.JS: Uma ferramenta revolucionária que possibilitou rodar aplicações em JavaScript/TypeScript fora dos navegadores, tornando possível criar aplicações apenas usando JavaScript. O NodeJS, é um JavaScript \"compilado\" em modo grosseiro de se dizer.',4);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (11,2,'@baseUrl%/assets/images/sass-splash.svg','SASS','SASS: Um CSS convencional, porém com riquezas de recursos. É um CSS pré-processado e convertido para linguagem de CSS padrão de navegadores.',5);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (12,2,'@baseUrl%/assets/images/less-splash.svg','LESS','LESS: Significa Leaner Style Sheets, é uma extensão de linguagem compatível com versões anteriores para a linguagem CSS.',6);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (13,3,'@baseUrl%/assets/images/react-splash.svg','React','React: Uma biblioteca JavaScript para aplicações WEB desenvolvida pelo Facebook',1);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (14,3,'@baseUrl%/assets/images/react-splash-2.svg','React + Next.JS + MUI','React em conjunto com Next.JS (Um framework exclusivo para trabalhar em conjunto con React e fazer o Server-Side Rendering) + MUI (Framework CSS do Material Design para React JS).',2);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (15,3,'@baseUrl%/assets/images/html5-css3-spash.svg','HTML 5 + CSS 3','HTML 5 e CSS 3: Desenvolvendo páginas da web',3);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (16,3,'@baseUrl%/assets/images/nodejs-splash.svg','Node.JS','Node.JS: Uma ferramenta revolucionária que possibilitou rodar aplicações em JavaScript/TypeScript fora dos navegadores, tornando possível criar aplicações apenas usando JavaScript. O NodeJS, é um JavaScript \"compilado\" em modo grosseiro de se dizer.',4);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (17,3,'@baseUrl%/assets/images/sass-splash.svg','SASS','SASS: Um CSS convencional, porém com riquezas de recursos. É um CSS pré-processado e convertido para linguagem de CSS padrão de navegadores.',5);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (18,3,'@baseUrl%/assets/images/less-splash.svg','LESS','LESS: Significa Leaner Style Sheets, é uma extensão de linguagem compatível com versões anteriores para a linguagem CSS.',6);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (19,4,'@baseUrl%/assets/images/flutter-logo-4k-qn.jpg','Flutter','Flutter: um framework desenvolvido pelo Google, que utiliza a linguagem de programação DART (também criada pelo Google), para desenvolvimento de aplicativos que rode em qualquer dispositivo (PC e celudar) e em qualuer sistema (Seja em Android, em Windows, em Linux, como uma aplicação WEB também ou até mesmo em qualquer sistema da Apple), de forma muito elegante (quando se trata de design), segurança também e muito mais. O aplicativo do NuBank é um exemplo perfeito de uma aplicativo feito com Flutter.',1);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (20,4,'@baseUrl%/assets/images/dart-wallpaper.jpg','Dart','Dart: Uma linguagem de programação desenvolvido pelo Google, para competir com o JavaScript na época, mas a idéia não vingou com os demais navegadores e, hoje é a linguagem importante para desenvolvimento de aplicativos multiplataforma utilizando o framework Flutter. Dart é uma linguagem extremamente similar ao Java. Aliás, quem vem do Java para o Flutter, se sentirá em casa ao codificar e se sentirá mais confortável ainda (vai sentir uma diferença como nunca tinha sentido antes), na hora de executar a aplicação feita com DART, de tão rápida que é a linguagem.',2);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (21,4,'@baseUrl%/assets/images/multiplataforma-flutter-dart.png','Multiplataforma Dart+Flutter','Aplicações multiplataforma de verdade utilizando a linguagem DART e o framework FLUTTER, ambos desenvolvidos pelo Google.',3);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (22,5,'@baseUrl%/assets/images/capa-como-ser-um-web-designer.jpg','Agencia de Web Designer','Uma mesa de escritório com um computador mostrando os detalhes sobre ser Web Designer',1);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (23,5,'@baseUrl%/assets/images/capa-mulher-web-designer.png','Mulher Web Designer','Uma mulher representando ser uma profissional de web designer.',2);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (24,5,'@baseUrl%/assets/images/capa-linguagens-em-alta.jpg','Ilustração de linguagens em alta','Ilustração de linguagens e softwares de designers em alta',3);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (25,5,'@baseUrl%/assets/images/mulher-designer.jpg','Profissional designer mulher em agência','Profissional de Designer mulher modelando protótipo de um projeto.',4);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (26,6,'@baseUrl%/assets/images/prancheta-banner-designer-grafico.png','Softwares profissionais para o designer','Apresentação rápida do Curso de Designer gráfico: Softwares da Adobe e CorelDRAW.',1);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (27,6,'@baseUrl%/assets/images/mulher-designer.jpg','Profissional designer mulher em agência','Profissional de Designer mulher modelando protótipo de um projeto.',2);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (28,6,'@baseUrl%/assets/images/Ilustracao-agencia-publicidade-notebook-tablet.png','Notebook e tablet para desenho','Ilustracao de uma agencia de publicidade, modelando desenho em algum software em um notebook e utilizando um tablet, para desenhar as linhas e traços.',3);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (29,6,'@baseUrl%/assets/images/mulher-designer-grafico.png','Profissional designer mulher modelando um cartão de visita','Profissional de Designer gráfico mulher modelando um cartão de visita no Adobe Illustrator.',4);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (30,7,'@baseUrl%/assets/images/publicidade.png','Publicitario com megafone','Um rapaz publicitário segurando um megafone e com um tablet na mão.',1);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (31,7,'@baseUrl%/assets/images/publicidade-e1513761867172-720.jpg','Idéias de Publicidade','Um megafone apontando para vários tipos de meio de comunicações diferentes.',2);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (32,7,'@baseUrl%/assets/images/publicidade-em-londres.png','Publicidade em telão de Londres','Um conjunto de telão com propaganda de várias empresas e marcas de vários ramos e empresas diferentes, mas empresas essas, multinacionais. Telão esse em um dos prédios em Londres.',3);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (33,7,'@baseUrl%/assets/images/microfone-e-megafone.png','Microfone + Megafone','Uma pessoa de Terno e Gravata com cabeça de Microfone à direita conversando com uma outra pessoa de terno e gravata com cabeça de megafone à esquerda. Com um fundo alaranjado, chão de taco, além das grandes quantidades de caixas, parecendo ser um galpão.',4);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (34,8,'@baseUrl%/assets/images/publicidade.png','Publicitario com megafone','Um rapaz publicitário segurando um megafone e com um tablet na mão.',1);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (35,8,'@baseUrl%/assets/images/publicidade-e1513761867172-720.jpg','Idéias de Publicidade','Um megafone apontando para vários tipos de meio de comunicações diferentes.',2);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (36,8,'@baseUrl%/assets/images/publicidade-em-londres.png','Publicidade em telão de Londres','Um conjunto de telão com propaganda de várias empresas e marcas de vários ramos e empresas diferentes, mas empresas essas, multinacionais. Telão esse em um dos prédios em Londres.',3);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (37,8,'@baseUrl%/assets/images/microfone-e-megafone.png','Microfone + Megafone','Uma pessoa de Terno e Gravata com cabeça de Microfone à direita conversando com uma outra pessoa de terno e gravata com cabeça de megafone à esquerda. Com um fundo alaranjado, chão de taco, além das grandes quantidades de caixas, parecendo ser um galpão.',4);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (38,9,'@baseUrl%/assets/images/idoso-no-notebook-2.png','Casal de idoso no laptop','Um casal de idosos utilizando o laptop',1);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (39,9,'@baseUrl%/assets/images/idoso-no-notebook.png','Idoso com laptop','Um senhor idoso utilizando um laptop',2);
INSERT INTO `Imagens_slide_curso` (`id`, `id_curso`, `url`, `texto_alternativo_img`, `descricao`, `posicao_imagem`) VALUES (40,9,'@baseUrl%/assets/images/aderindo-a-tecnologia.png','Aderindo a Tecnologia','Um dedo apertando alguma tecla do teclado de computador e do lado esquerdo mostrando um mapa mundial, representando a comunicação e embaixo desse mapa, mostrando alguma codificação, representando que a pessoa está entrando no mundo da tecnologia.',3);
/*!40000 ALTER TABLE `Imagens_slide_curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Linha_do_tempo`
--

DROP TABLE IF EXISTS `Linha_do_tempo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Linha_do_tempo` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Id da linha do tempo',
  `url_imagem` text NOT NULL COMMENT 'Url da imagem',
  `txt_alternativo` varchar(100) NOT NULL COMMENT 'Texto alternativo da imagem, se caso ela não for carregada com sucesso...',
  `img_titulo` varchar(255) NOT NULL COMMENT 'Texto a ser exibido quando aponta com o mouse por cima da imagem ou quando o usuário utiliza recursos de acessibilidade.',
  `titulo` varchar(100) NOT NULL COMMENT 'Titulo para esta linha do tempo',
  `texto` varchar(2047) NOT NULL COMMENT 'Texto descritivo para ser apresentado ao usuário.',
  `data_ocorrencia` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Data da ocorrência (apenas para ordenação correta)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Linha_do_tempo_id_uindex` (`id`),
  UNIQUE KEY `Linha_do_tempo_img_titulo_uindex` (`img_titulo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Linha do tempo de todos os acontecimentos relevantes a serem apresentados ao cliente.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Linha_do_tempo`
--

LOCK TABLES `Linha_do_tempo` WRITE;
/*!40000 ALTER TABLE `Linha_do_tempo` DISABLE KEYS */;
INSERT INTO `Linha_do_tempo` (`id`, `url_imagem`, `txt_alternativo`, `img_titulo`, `titulo`, `texto`, `data_ocorrencia`) VALUES (1,'@baseUrl%/assets/images/estudantes.jpg','estudantes','Grupo de estudantes que criou a Eduk Info','Em Janeiro de 2022','Nascemos através de um grupo de alunos que fez um trabalho sobre desenvolvimento web com todas as tecnologias, ferramentas e linguagens usadas na web. Trabalho esse que na verdade que foi a primeira avaliação para compor uma parte da nota final dos componentes (alunos) desse grupo de estudantes.','2022-01-23 00:00:00');
INSERT INTO `Linha_do_tempo` (`id`, `url_imagem`, `txt_alternativo`, `img_titulo`, `titulo`, `texto`, `data_ocorrencia`) VALUES (2,'@baseUrl%/assets/images/capa-linguagens-em-alta.jpg','linguagens em alta','Tendências da tecnologia para a web','Em Fevereiro de 2022','Lançamos os principais cursos de programação mais focado para a WEB e para dispositivos móveis, além de também para os designers.','2022-02-08 00:00:00');
INSERT INTO `Linha_do_tempo` (`id`, `url_imagem`, `txt_alternativo`, `img_titulo`, `titulo`, `texto`, `data_ocorrencia`) VALUES (3,'@baseUrl%/assets/images/idoso-no-notebook-2.png','Idoso em laptop','Um senhor idoso utilizando um laptop','Em Março de 2022','Lançamos o curso de informática básica para idosos que nunca tiveram contato com alguma tecnologia. Inclusive, esse(a) idoso(a) até aprende a usar redes sociais.','2022-03-02 00:00:00');
/*!40000 ALTER TABLE `Linha_do_tempo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Materia_cursos`
--

DROP TABLE IF EXISTS `Materia_cursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Materia_cursos` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id da materia (ou da disciplina)',
  `nome` varchar(256) NOT NULL COMMENT 'nome da materia do curso (ou da disciplina)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Materia_cursos_id_uindex` (`id`),
  UNIQUE KEY `Materia_cursos_nome_uindex` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Materia dos cursos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Materia_cursos`
--

LOCK TABLES `Materia_cursos` WRITE;
/*!40000 ALTER TABLE `Materia_cursos` DISABLE KEYS */;
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (51,'Adicionando pacotes e bibliotecas');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (12,'Adicionando pacotes/bibliotecas');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (106,'Anúncios em Jogos');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (102,'Anúncios nas Redes Sociais');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (104,'Anúncios via Facebook/Instagram');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (103,'Anúncios via Google ADS');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (105,'Anúncios via Google Twitter');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (21,'Apresentando e trabalhando com Angular Material (Framework CSS com Material Design para Angular): Criando um projeto de gerenciamento de estoque com login e senha');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (43,'Apresentando e trabalhando com Bootstrap (Framework CSS criado pelo Twitter) utilizando o VueJS: Criando um projeto de gestão de finanças.');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (23,'Apresentando e trabalhando com Bulma CSS (framework 100% em CSS criado por um dos membros da comunidade) e implementando código nativo do angular...');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (59,'Apresentando e trabalhando com Bulma CSS (framework 100% em CSS criado por um dos membros da comunidade) e implementando código nativo do React...');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (44,'Apresentando e trabalhando com Bulma CSS (framework 100% em CSS criado por um dos membros da comunidade) e implementando código nativo do VueJS...');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (22,'Apresentando e trabalhando com NGX-Bootstrap (Framework CSS criado pelo Twitter para Angular): Criando um projeto de gestão de finanças');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (57,'Apresentando e trabalhando com o MUi (Framework CSS com Material Design para ReactJS e React Native): Criando um sistema de gerenciamento de estoque com login e senha');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (58,'Apresentando e trabalhando com React-Bootstrap (Framework CSS criado pelo Twitter para ReactJS e React Native): Criando um projeto de Gestão de Finanças');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (42,'Apresentando e trabalhando com Vuetify (Framework CSS com Material Design para VueJS): criando um projeto de gerenciamento de estoque com Login e Senha ');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (11,'Apresentando o Angular Universal e Conceitos de Server Side Rendering');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (33,'Apresentando o Nuxt.JS e conceitos de Server Side Rendering');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (74,'Autenticação com Flutter');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (27,'Build do projeto Angular para produção');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (61,'Build do Projeto ReactJS para produção');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (46,'Build do Projeto VueJS para produção');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (73,'Chamadas HTTP e comunicação com BackEnd de uma aplicação WEB com Flutter');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (15,'Componentes reativos do Angular');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (36,'Componentes Reativos do VueJS');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (40,'Comunicação com Back-End (Com ou sem formulários)');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (19,'Comunicação com o Back-End (Com ou sem formulários)');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (56,'Comunicação do projeto ReactJS com BackEnd, utilizando Axios');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (4,'Conhecendo o SASS e LESS (alternativas ao CSS)');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (96,'Criação de artes rápidas e minimalistas com Adobe CC Express');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (9,'Criando o primeiro projeto Angular com um exemplo de \"Hello World\".');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (49,'Criando o primeiro projeto com um exemplo de \"Hello World\".');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (31,'Criando o primeiro projeto VueJS com um exemplo de \"Hello World\".');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (70,'Criando telas, componente e modelando-as, com Flutter');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (28,'Deploy em Produção e Imagens Docker');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (84,'Desenho Vetorial com CorelDraw');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (83,'Desenho Vetorial com Illustrator');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (85,'Desenho Vetorial com Inkscape');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (75,'Desenvolvendo códigos nativos do(s) sistema(s) de destino e utilizando-os no DART');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (107,'Digitação');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (16,'Diretivas em Angular');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (37,'Diretivas em VueJS');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (91,'Dreamweaver');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (98,'Edição de videos com DaVinci Resolve');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (97,'Edição de videos com Premiere Pro');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (81,'Edição e Tratamento de Imagens com Corel PhotoPaint');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (82,'Edição e Tratamento de Imagens com GIMP');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (80,'Edição e Tratamento de Imagens com Photoshop');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (94,'Editoração de Jornais e Revistas com CorelDraw');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (93,'Editoração de Jornais e Revistas com InDesign');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (95,'Editoração de Jornais e Revistas com Scribus');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (110,'Excel: Utilizando planilha eletrônica de uma forma muito básica e organizar melhor as tarefas e finanças');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (18,'Formulários com Angular (com Introdução ao \"Two Way Data Binding\", validação dos campos, upload de arquivos, pesquisa, etc)');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (72,'Formulários com Flutter');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (39,'Formulários com VueJS');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (7,'Fundamentos do NodeJS, gerenciamento de pacotes e linha de comando.');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (113,'História da Informática e Comparação do computador moderno com máquinas antigas');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (3,'HTML e CSS completo');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (111,'Internet e e-mail: Ampliando o vasto conhecimento, entretenimento, compras pela internet, além da comunicação com o mundo...');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (50,'Introdução à biblioteca React e o framework Next.JS, juntamente com o JSX (para JavaScript) ou TSX (para TypeScript).');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (13,'Introdução a Componentes Angular e Criação de Páginas');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (34,'Introdução a componentes e criação de páginas');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (52,'Introdução a Componentes, Styled Components e Criação de páginas');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (35,'Introdução a Injeção de Dependências para VueJS');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (14,'Introdução a Injeção de Dependências, Criando Serviços e Guards para as Rotas no Angular');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (66,'Introdução a linguagem C++');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (67,'Introdução a linguagem de programação DART');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (62,'Introdução a linguagem Java');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (63,'Introdução a linguagem Kotlin');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (64,'Introdução a linguagem Objective-C');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (65,'Introdução a linguagem Swift');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (25,'Introdução a Testes Automatizados');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (69,'Introdução a Widgets, em Flutter');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (10,'Introdução ao Angular e realizando as configurações iniciais');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (53,'Introdução ao React Hooks');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (6,'Introdução ao TypeScript');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (32,'Introdução ao VueJS e realizando as configurações iniciais');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (2,'Introdução de Programação Orientada a Objetos');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (88,'Introdução e Básico de JavaScript');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (89,'Introdução e Básico de PHP');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (24,'Introdução e uso do GIT');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (5,'Intrudução e Fundamentos do JavaScript e EcmaScript');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (1,'Lógica de Programação');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (71,'Menus, Botões, e Listagens com Flutter');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (101,'Modelagem 3D com Blender');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (86,'Modelando Protótipo com Adobe XD');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (87,'Modelando Protótipo com Figma');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (29,'Mudando a versão do projeto em Angular para a versão mais recente e refazendo o Build + Deploy');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (47,'Mudando a versão do projeto em VueJS para a versão mais recente e refazendo o Build + Deploy');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (92,'Noções Básicas da Língua Portuguesa');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (99,'Pós Produção com After Effects');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (100,'Pós Produção com Natron');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (112,'PowerPoint: Faça apresentações em slides, à um determinado público, podendo ser em palestras, reuniões, etc.');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (68,'Preparação completa do ambiente de desenvolvimento para Flutter');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (48,'Preparação completa do ambiente de desenvolvimento para React + Linha de comando');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (30,'Preparação completa do ambiente de desenvolvimento para VueJS, apresentando o Vue CLI e interface gráfica de gerenciamento de projetos do VueJS');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (8,'Preparação completa do ambiente para desenvolvimento para Angular e apresentação do Angular CLI');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (26,'Realização de Testes automatizados em Angular');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (60,'Realização de Testes automatizados em ReactJS');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (45,'Realização de Testes automatizados em VueJS');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (77,'Realizando o build de produção do projeto em Flutter para Android e divulgando no Google Play Store');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (78,'Realizando o build de produção do projeto em Flutter para iOS e divulgando no App Store');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (79,'Realizando o build de produção do projeto em Flutter para Windows e divulgando na Microsoft Store');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (76,'Realizando testes automatizados no Flutter');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (55,'Reuso de componentes');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (20,'Reuso de Componentes Angular');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (41,'Reuso de Componentes VueJS');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (17,'Roteamento (Definindo Rotas, Link de Rotas, Proteção das mesmas, etc) em Angular');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (38,'Roteamento (Definindo Rotas, Link de Rotas, Proteção das mesmas, etc) em VueJS');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (54,'Roteamento com ReactRouterDom');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (108,'Windows: Aprendendo a usar um PC popular e moderno');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (109,'Word: Editor de texto muito poderoso da Microsoft');
INSERT INTO `Materia_cursos` (`id`, `nome`) VALUES (90,'WordPress');
/*!40000 ALTER TABLE `Materia_cursos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Recuperacao_senha`
--

DROP TABLE IF EXISTS `Recuperacao_senha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Recuperacao_senha` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'ID principal...',
  `id_usuario` int NOT NULL COMMENT 'ID do usuário no qual precisará trocar a senha...',
  `token_temporario` varchar(511) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Código de confirmação para liberar acesso  de trocar a senha...',
  `vencimento` datetime NOT NULL DEFAULT ((now() + interval 1 day)) COMMENT 'Data de vencimento do token em que o usuario solicitou. Se passar desse prazo, tera que fazer uma nova solicitaçao de recuperaçao de senha.',
  `usado` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica se este token já foi utilizado. Isto é, se já foi feita a troca de senha.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Recuperacao_senha_id_uindex` (`id`),
  KEY `Recuperacao_senha_Usuarios_id_fk` (`id_usuario`),
  CONSTRAINT `Recuperacao_senha_Usuarios_id_fk` FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci COMMENT='Nesta tabela são armazenados todos os tokens temporários de recuperação de senha...';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Recuperacao_senha`
-- These data was generated by PHP backend.
--

LOCK TABLES `Recuperacao_senha` WRITE;
/*!40000 ALTER TABLE `Recuperacao_senha` DISABLE KEYS */;
INSERT INTO `Recuperacao_senha` (`id`, `id_usuario`, `token_temporario`, `vencimento`, `usado`) VALUES (1,19,'53562400262a2df7a2ea4d5.50340642','2022-06-11 03:06:50',1);
INSERT INTO `Recuperacao_senha` (`id`, `id_usuario`, `token_temporario`, `vencimento`, `usado`) VALUES (1,27,'53562400262a2df7a2ea4d5.50340642','2022-06-11 03:06:50',0);
/*!40000 ALTER TABLE `Recuperacao_senha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Telefones_usuarios`
-- These data are fake and generated by https://www.4devs.com.br
--

DROP TABLE IF EXISTS `Telefones_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Telefones_usuarios` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'Id do telefone corrente, para melhor identificaçao...',
  `id_usuario` int NOT NULL COMMENT 'Id do Usuario ao qual este telefone pertence',
  `descricao` varchar(50) NOT NULL COMMENT 'Descrição do telefone',
  `ddd` int NOT NULL COMMENT 'DDD do telefone do cliente',
  `telefone` varchar(9) NOT NULL COMMENT 'Telefone do usuario',
  `whatsapp` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'O usuário informou se o telefone serve ou não serve, para contato via WhatsApp...',
  `telegram` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'O usuário informou se o telefone serve ou não serve, para contato via telegram...',
  `wechat` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'O usuário informou se o telefone serve ou não serve, para contato via WeChat...',
  `sms` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'O usuário informou se o telefone serve ou não serve, para contato via SMS...',
  `chamadas` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'O usuário informou se o telefone serve ou não serve, para realizar chamadas tradicionais, sem ser via aplicativos (como WhatsApp/Telegram)...',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Telefones_usuarios_id_uindex` (`id`),
  KEY `Telefones_usuarios_Usuarios_id_fk` (`id_usuario`),
  CONSTRAINT `Telefones_usuarios_Usuarios_id_fk` FOREIGN KEY (`id_usuario`) REFERENCES `Usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Telefones em que os usuários cadastraram';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Telefones_usuarios`
-- These data are fake and generated by https://www.4devs.com.br
--

LOCK TABLES `Telefones_usuarios` WRITE;
/*!40000 ALTER TABLE `Telefones_usuarios` DISABLE KEYS */;
INSERT INTO `Telefones_usuarios` (`id`, `id_usuario`, `descricao`, `ddd`, `telefone`, `whatsapp`, `telegram`, `wechat`, `sms`, `chamadas`) VALUES (1,19,'Telefone da minha casa',43,'38988655',0,0,0,0,0);
INSERT INTO `Telefones_usuarios` (`id`, `id_usuario`, `descricao`, `ddd`, `telefone`, `whatsapp`, `telegram`, `wechat`, `sms`, `chamadas`) VALUES (2,19,'meu celular',43,'982657178',0,0,0,0,0);
INSERT INTO `Telefones_usuarios` (`id`, `id_usuario`, `descricao`, `ddd`, `telefone`, `whatsapp`, `telegram`, `wechat`, `sms`, `chamadas`) VALUES (3,20,'Telefone de casa',12,'38614838',0,0,0,0,0);
INSERT INTO `Telefones_usuarios` (`id`, `id_usuario`, `descricao`, `ddd`, `telefone`, `whatsapp`, `telegram`, `wechat`, `sms`, `chamadas`) VALUES (4,20,'meu celular',12,'991553728',0,0,0,0,0);
INSERT INTO `Telefones_usuarios` (`id`, `id_usuario`, `descricao`, `ddd`, `telefone`, `whatsapp`, `telegram`, `wechat`, `sms`, `chamadas`) VALUES (5,22,'Telefone de casa',48,'27310028',0,0,0,0,0);
INSERT INTO `Telefones_usuarios` (`id`, `id_usuario`, `descricao`, `ddd`, `telefone`, `whatsapp`, `telegram`, `wechat`, `sms`, `chamadas`) VALUES (6,22,'meu celular',48,'997681960',0,0,0,0,0);
INSERT INTO `Telefones_usuarios` (`id`, `id_usuario`, `descricao`, `ddd`, `telefone`, `whatsapp`, `telegram`, `wechat`, `sms`, `chamadas`) VALUES (7,25,'Telefone de casa',35,'983452064',0,0,0,0,0);
INSERT INTO `Telefones_usuarios` (`id`, `id_usuario`, `descricao`, `ddd`, `telefone`, `whatsapp`, `telegram`, `wechat`, `sms`, `chamadas`) VALUES (8,25,'meu celular',35,'26204805',0,0,0,0,0);
INSERT INTO `Telefones_usuarios` (`id`, `id_usuario`, `descricao`, `ddd`, `telefone`, `whatsapp`, `telegram`, `wechat`, `sms`, `chamadas`) VALUES (9,26,'Telefone de casa',79,'39622039',0,0,0,0,0);
INSERT INTO `Telefones_usuarios` (`id`, `id_usuario`, `descricao`, `ddd`, `telefone`, `whatsapp`, `telegram`, `wechat`, `sms`, `chamadas`) VALUES (10,26,'Meu celular',79,'998373315',0,0,0,0,0);
INSERT INTO `Telefones_usuarios` (`id`, `id_usuario`, `descricao`, `ddd`, `telefone`, `whatsapp`, `telegram`, `wechat`, `sms`, `chamadas`) VALUES (11,27,'Telefone de casa',61,'28894994',0,0,0,0,0);
INSERT INTO `Telefones_usuarios` (`id`, `id_usuario`, `descricao`, `ddd`, `telefone`, `whatsapp`, `telegram`, `wechat`, `sms`, `chamadas`) VALUES (12,27,'Meu celular',61,'988162639',0,0,0,0,0);
INSERT INTO `Telefones_usuarios` (`id`, `id_usuario`, `descricao`, `ddd`, `telefone`, `whatsapp`, `telegram`, `wechat`, `sms`, `chamadas`) VALUES (13,28,'Telefone fixo fictício',68,'39136900',0,0,0,0,0);
INSERT INTO `Telefones_usuarios` (`id`, `id_usuario`, `descricao`, `ddd`, `telefone`, `whatsapp`, `telegram`, `wechat`, `sms`, `chamadas`) VALUES (14,28,'Telefone Celular fictício',68,'996890786',0,0,0,0,0);
/*!40000 ALTER TABLE `Telefones_usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Unidades`
--

DROP TABLE IF EXISTS `Unidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Unidades` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Id da Unidade',
  `endereco` varchar(150) NOT NULL COMMENT 'Endereço da unidade',
  `numero` int DEFAULT NULL COMMENT 'Número da loja (Do endereço)',
  `complemento` varchar(50) DEFAULT NULL COMMENT 'Complemento da loja (se aplica inclusive, em caso de Lote e Quadra)',
  `bairro` varchar(30) NOT NULL COMMENT 'Bairro ao qual fica a unidade',
  `municipio` varchar(50) NOT NULL COMMENT 'Município ao qual fica a unidade',
  `estado` varchar(2) NOT NULL COMMENT 'Sigla do estado ao qual fica a unidade',
  `cep` varchar(8) NOT NULL,
  `descricao` varchar(50) NOT NULL COMMENT 'Nome da unidade (geralmente se da ao nome do bairro ou do distrito)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Unidades_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Unidades da EdukInfo pelo Brasil';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Unidades`
-- These data are fake and generated by https://www.4devs.com.br
--

LOCK TABLES `Unidades` WRITE;
/*!40000 ALTER TABLE `Unidades` DISABLE KEYS */;
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (1,'Rua Gavião Peixoto',343,NULL,'Icaraí','Niterói','RJ','24230093','Unidade Niterói');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (2,'Avenida Manoel Duarte',853,NULL,'Santa Terezinha','Mesquita','RJ','26554160','Unidade Mesquita');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (3,'Rua Um',940,NULL,'Vila Santa Cruz','Duque de Caxias','RJ','25260069','Unidade Caxias 2 - Interior');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (4,'Rua Clóvis Bevilacqua',999,NULL,'Cônego','Nova Friburgo','RJ','28621150','Unidade Nova Friburgo');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (5,'Estrada Rúbens dos Reis Sales',971,NULL,'Nova Cidade','Nilópolis','RJ','26530210','Unidade Nilópolis');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (6,'Rua Adelina Leal',619,NULL,'Outeiro das Pedras','Itaboraí','RJ','24812272','Unidade Itaboraí');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (7,'Rua Helena',403,NULL,'Rodilândia','Nova Iguaçu','RJ','26083580','Unidade Nova Iguaçu');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (8,'Rua União dos Palmares',422,NULL,'Campo Grande','Rio de Janeiro','RJ','23015180','Unidade Z.O 2 - Campo Grande');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (9,'Rua Zagreb',234,NULL,'Bangu','Rio de Janeiro','RJ','21862775','Unidade Z.O 1 - Bangu');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (10,'Avenida São Guilherme de Norwich',123,NULL,'Anil','Rio de Janeiro','RJ','22750390','Unidade Taquara');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (11,'Rua São Frederico',161,NULL,'Estácio','Rio de Janeiro','RJ','20250260','Unidade Estácio');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (12,'Rua Manuel Vieira',74,NULL,'Centro','Duque de Caxias','RJ','25020210','Unidade Caxias 1 - Centro');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (13,'Avenida Almirante Barroso',52,NULL,'Centro','Rio de Janeiro','RJ','20031000','Unidade Centro RJ');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (14,'Rua José de Alencar',739,NULL,'Vila Hulda Rocha','Resende','RJ','27522090','Unidade Resende');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (15,'Rua Duzentos e Trinta e Dois',502,NULL,'Conforto','Volta Redonda','RJ','27263530','Unidade Volta Redonda');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (16,'Rua F',839,NULL,'Parque Santa Rita','Magé','RJ','25906014','Unidade Magé');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (17,'Rua Dolores Carvalho Vasconcelos',332,NULL,'Glória','Macaé','RJ','27937600','Unidade Macaé');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (18,'Avenida Prefeito Jorge Júlio Costa dos Santos',200,NULL,'Centro','Belford Roxo','RJ','26130091','Unidade Belford Roxo');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (19,'Estrada do Galeão',2436,NULL,'Portuguesa','Rio de Janeiro','RJ','21931935','Unidade Ilha do Governador');
INSERT INTO `Unidades` (`id`, `endereco`, `numero`, `complemento`, `bairro`, `municipio`, `estado`, `cep`, `descricao`) VALUES (20,'Rua Manoel João Gonlçalves',316,NULL,'Alcântara','São Gonçalo','RJ','24711080','Unidade São Gonçalo');
/*!40000 ALTER TABLE `Unidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Usuarios`
-- These data are fake and generated by https://www.4devs.com.br
--

DROP TABLE IF EXISTS `Usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Usuarios` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Id do cliente',
  `nome` varchar(150) NOT NULL COMMENT 'Primeiro nome do cliente (Para pessoas físicas) OU Razão Social (Para Pessoas juridicas)',
  `sobrenome` varchar(150) NOT NULL COMMENT 'Sobrenome do cliente',
  `documento` varchar(20) NOT NULL COMMENT 'Começa com o ''PF'' e o número do CPF em caso de pessoa física.\nOu então com ''PJ'' e o número do CNPJ em caso de pessoas jurídicas.',
  `genero` char(1) DEFAULT NULL COMMENT '''M'' para masculino, ''F'' para feminino ou ''O'' para outros.',
  `aniversario` datetime DEFAULT NULL COMMENT 'Data de aniversário do cliente ou data de inicio das atividades da empresa',
  `email` varchar(255) NOT NULL COMMENT 'e-mail do cliente.',
  `senha` varchar(90) NOT NULL COMMENT 'Senha do usuário armazenada com o algoritmo BCrypt.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Usuarios_documento_uindex` (`documento`),
  UNIQUE KEY `Usuarios_email_uindex` (`email`),
  UNIQUE KEY `Usuarios_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Todos os usuários/clientes estão aqui';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuarios`
--

LOCK TABLES `Usuarios` WRITE;
/*!40000 ALTER TABLE `Usuarios` DISABLE KEYS */;
INSERT INTO `Usuarios` (`id`, `nome`, `sobrenome`, `documento`, `genero`, `aniversario`, `email`, `senha`) VALUES (19,'Cauê','Emanuel Barbosa','PF85855570525','M','1995-04-06 00:00:00','caue_barbosa@cssmi.com.br','$2y$07$dxTB1kmijNIJZ4Qo3XFIQuPiQR0DjthPNOq7QWn7lWfrHHq.KJvJO');
INSERT INTO `Usuarios` (`id`, `nome`, `sobrenome`, `documento`, `genero`, `aniversario`, `email`, `senha`) VALUES (20,'Fabiana','Antônia Betina Nogueira','PF30137809328','M','1968-05-10 00:00:00','fabianaantonianogueira@mtc.eng.br','$2y$07$Ge0KYQSdsyc.5ODN2WZmwuQXXDAqp7YhVXu58zNFwZ4ldPViocnCm');
INSERT INTO `Usuarios` (`id`, `nome`, `sobrenome`, `documento`, `genero`, `aniversario`, `email`, `senha`) VALUES (22,'Joana','Kamilly Viana','PF19980708328','M','2001-03-22 00:00:00','joana_viana@mindesign.com.br','$2y$07$zFvEBf/SZ.dmp0xRLzvZr.7WMHSWq6EWl4ZTZZ2bTnBnYxPzxspYu');
INSERT INTO `Usuarios` (`id`, `nome`, `sobrenome`, `documento`, `genero`, `aniversario`, `email`, `senha`) VALUES (25,'Cláudia','Francisca Corte Real','PF28293269030','F','1965-06-04 00:00:00','claudia.francisca.cortereal@poolrescue.com.br','$2y$07$GcgRb9T9biRvpCZYMvni0OSzHRl1nGARkLXwVN/8QuC9Qz/ymzWHi');
INSERT INTO `Usuarios` (`id`, `nome`, `sobrenome`, `documento`, `genero`, `aniversario`, `email`, `senha`) VALUES (26,'Pedro Henrique','Nelson Julio Moura','PF17199162332','M','1979-04-24 00:00:00','pedrohenriquemoura@tetrapark.com','$2y$07$stEJXaJBudlDGbLUBnlAMeFV5B17ywz/VhiHTYJcOgfOT4WSwamiu');
INSERT INTO `Usuarios` (`id`, `nome`, `sobrenome`, `documento`, `genero`, `aniversario`, `email`, `senha`) VALUES (27,'Milena','Antônia Brenda Ramos','PF87255723934','F','1993-05-01 00:00:00','milena.antonia.ramos@embraer.com','$2y$07$YjqzPZ2L0fZw4kLEDkzQSOq65UFwZC7WF7TaEoIvz37AGz3M0J2pK');
INSERT INTO `Usuarios` (`id`, `nome`, `sobrenome`, `documento`, `genero`, `aniversario`, `email`, `senha`) VALUES (28,'Isadora','Lívia Novaes','PF83867105197','F','1990-05-02 00:00:00','isadora.livia.novaes@outloock.com.br','$2y$07$8p1smsNFxkgYzrKFv538g.hdKCJV55lTSeg/zPVloKv6MksqrpzYK');
/*!40000 ALTER TABLE `Usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS `faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faq` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'id da FAQ',
  `pergunta` varchar(255) DEFAULT NULL COMMENT 'A pergunta em si',
  `resposta` varchar(2047) NOT NULL COMMENT 'Resposta da pergunta',
  PRIMARY KEY (`id`),
  UNIQUE KEY `faq_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Todas as perguntas frequentes (Ou pelo menos alguma suposta pergunta frequente) estao aqui';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq`
--

LOCK TABLES `faq` WRITE;
/*!40000 ALTER TABLE `faq` DISABLE KEYS */;
INSERT INTO `faq` (`id`, `pergunta`, `resposta`) VALUES (1,'Todos os cursos aqui são somente voltados à T.I?','Não Temos cursos para os bem mais iniciantes, que nunca tiveram contato com um PC, Laptop ou até mesmo um celular na vida. Assim como para qualquer área também.');
INSERT INTO `faq` (`id`, `pergunta`, `resposta`) VALUES (2,'Tem cursos voltados à administração?','Ainda não temos, mas pretendemos lançar algum em breve!');
INSERT INTO `faq` (`id`, `pergunta`, `resposta`) VALUES (3,'Sobre o curso de informática básica, ensina Linux ou MacOS também?','Ainda não, somente Windows 10 por enquanto. Se caso houver necessidade de mercado, pretendemos colocar esses cursos muito em breve. Sobre os pacotes office, ministramos aula do Office 365 (da Microsoft), Google Docs, OnlyOffice e LibreOffice (ambos são gratuitos, apesar do OnlyOffice existir uma versão paga).');
INSERT INTO `faq` (`id`, `pergunta`, `resposta`) VALUES (4,'Sobre o curso de designer, ensina todas as plataformas voltada ao designer?','Sim, desde as plataformas gratuitas até as plataformas pagas. Ensinamos a fazer diagramação ou tratamento de imagens, pronta para impressão ou para ser divulgada na internet. Assim como ensinamos também a fazer prototipagens de sites/aplicativos/sistemas em plataformas gratuitas e pagas, pronto para ser apresentado ao cliente final.');
INSERT INTO `faq` (`id`, `pergunta`, `resposta`) VALUES (5,'Sobre os cursos de programação, terei direito a licensa de alguma IDE paga?','Dentro de alguma eventual campanha promocional e, dependendo dos termos no regulamento dessa eventual promoção, sim! Fora disso, somente o VSCode mesmo, para todas as linguagens nas quais ministramos aula.');
INSERT INTO `faq` (`id`, `pergunta`, `resposta`) VALUES (6,'Sobre os cursos de dados, aprenderei matemática também?','Poderá ser aplicado parte da matemática em algumas matérias nos cursos voltados à analise de dados, dependendo do cenário em que é apresentado na aula. Podendo tanto ser matemática de ensino fundamental ou matemática de ensino médio.');
/*!40000 ALTER TABLE `faq` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-15  1:24:55
