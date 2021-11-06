-- Cria o bancode dados
CREATE SCHEMA `saoRoqueVoce` DEFAULT CHARACTER SET utf8 ;

--Cria tabela para de crud para teste
CREATE TABLE `saoRoqueVoce`.`crud` (
  `id` INT NOT NULL,
  `nome` VARCHAR(255) NULL,
  `mensagem` TEXT(1000) NULL,
  `data` TIMESTAMP(2) NULL,
  PRIMARY KEY (`id`));

-- Cria o tabela de administradores do sistema
CREATE TABLE `saoRoqueVoce`.`roots` (
  `idRoot` INT NOT NULL AUTO_INCREMENT,
  `rootName` VARCHAR(255) NULL,
  `userName` VARCHAR(30) NULL,
  `type` INT(1) NULL DEFAULT 2,
  `email` VARCHAR(255) NULL,
  `password` VARCHAR(255) NULL,
  `data` TIMESTAMP(2) NULL,
  PRIMARY KEY (`idRoot`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE);

-- Cria a tabela de usuarios do sistema
CREATE TABLE `saoRoqueVoce`.`users` (
  `idUser` INT NOT NULL AUTO_INCREMENT,
  `firstName` VARCHAR(30) NULL,
  `lastName` VARCHAR(255) NULL,
  `userName` VARCHAR(255) NULL,
  `birthday` TIMESTAMP(2) NULL,
  `email` VARCHAR(255) NULL,
  `password` VARCHAR(255) NULL,
  `data` TIMESTAMP(2) NULL,
  `idSetting` INT(20) NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE);


-- Cria a tabela de configurações do  usuario do sistema
CREATE TABLE `saoRoqueVoce`.`userSettings` (
  `idSetting` INT NOT NULL AUTO_INCREMENT,
  `news` INT(1) NOT NULL ,
  `tourristSpotsTips` INT(1) NOT NULL ,
  `restaurantTips` INT(1) NOT NULL ,
  `eventAlert` INT(1) NOT NULL ,
  `activateLocation` INT(1) NOT NULL ,
  PRIMARY KEY (`idSetting`)
);


-- Cria a tabela de comentário
CREATE TABLE `saoRoqueVoce`.`comments` (
  `idComment` INT NOT NULL AUTO_INCREMENT,
  `idUser` INT NULL,
  `idApp` INT NULL,
  `idCommentRating` INT NULL,
  `stars` INT(1) NULL,
  `description` TEXT(1000) NULL,
  `date` TIMESTAMP(2) NULL,
  PRIMARY KEY (`idComment`)
);

--Cria tabela de avaliaçao de comentário
CREATE TABLE `saoRoqueVoce`.`commentRatings` (
  `idcommentRating` INT NOT NULL AUTO_INCREMENT,
  `yesUserful` INT NULL,
  `notUserful` INT NULL,
  PRIMARY KEY (`idcommentRating`)
);

--Cria a tabela de estatistica para avaliação geral de uma atração
CREATE TABLE `saoRoqueVoce`.`statistics` (
  `idstatistic` INT NOT NULL AUTO_INCREMENT,
  `percentagemOfStars` FLOAT NULL,
  `totalStars` INT NULL,
  `averageCost` INT NULL,
  `totalRating` INT NULL,
  PRIMARY KEY (`idstatistic`)
);

--Cria uma tabela para horario de funcionamento
CREATE TABLE `saoRoqueVoce`.`serviceHours` (
  `idserviceHour` INT NOT NULL AUTO_INCREMENT,
  `timeInTheWeek` VARCHAR(45) NULL,
  `timeOnSaturdays` VARCHAR(45) NULL,
  `timeOnSunday` VARCHAR(45) NULL,
  `timeOnHoliday` VARCHAR(45) NULL,
  `exceptions` VARCHAR(45) NULL,
  PRIMARY KEY (`idserviceHour`)
);

--Cria a tabela de questoes sobre o local
CREATE TABLE `saoRoqueVoce`.`options` (
  `idOption` INT NOT NULL AUTO_INCREMENT,
  `breakfast` INT(1) NOT NULL, 
  `pool` INT(1) NOT NULL, 
  `airConditioning` INT(1) NOT NULL, 
  `parking` INT(1) NOT NULL, 
  `snack` INT(1) NOT NULL, 
  `academy` INT(1) NOT NULL, 
  `wifi` INT(1) NOT NULL, 
  `accessibillity` INT(1) NOT NULL, 
  `pub` INT(1) NOT NULL,
  `pets` INT(1) NOT NULL,
  `animals` INT(1) NOT NULL, 
  `trail` INT(1) NOT NULL, 
  `bikeTrail` INT(1) NOT NULL, 
  `nature` INT(1) NOT NULL, 
  `toys` INT(1) NOT NULL, 
  `iceCreanPalor` INT(1) NOT NULL, 
  `winery` INT(1) NOT NULL, 
  `drink` INT(1) NOT NULL, 
  `data` INT(1) NOT NULL, 
  `restaurant` INT(1) NOT NULL, 
  `liveMusic` INT(1) NOT NULL, 
  `typicalFoods` INT(1) NOT NULL, 
  `clothes` INT(1) NOT NULL, 
  `shoes` INT(1) NOT NULL, 
  `technology` INT(1) NOT NULL, 
  `convenience` INT(1) NOT NULL, 
PRIMARY KEY (`idOption`)
);


-- Cria a tabela de cliente do sistema
   CREATE TABLE `saoRoqueVoce`.`customers` (
    `idCustomer` INT NOT NULL AUTO_INCREMENT,
    `firstName` VARCHAR(30) NULL,
    `lastName` VARCHAR(255) NULL,
    `userName` VARCHAR(30) NULL,
    `birthday` TIMESTAMP(2) NULL,
    `email` VARCHAR(255) NULL,
    `phone` VARCHAR(17) NULL,
    `businessName` VARCHAR(255) NULL,
    `password` VARCHAR(255) NULL,
    `data` TIMESTAMP(2) NULL,
    `terms` INT(1) NULL DEFAULT 1,
    `type` INT(1) NULL DEFAULT 1,
    PRIMARY KEY (`idCustomer`),
    UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE
  );


  -- Cria a tabela de endereço das atrações
  CREATE TABLE `saoRoqueVoce`.`adrresses` (
    `idAddress` INT NOT NULL AUTO_INCREMENT,
    `cep` VARCHAR(8) NULL,
    `address` VARCHAR(255) NULL,
    `number` INT NULL,
    `complement` VARCHAR(30) NULL,
    `district` VARCHAR(100) NULL,
    `city` VARCHAR(50) NULL,
    `state` VARCHAR(2) NULL,
    PRIMARY KEY (`idAddress`)
  );

 -- Cria a tabela de endereço das atrações
  CREATE TABLE `saoRoqueVoce`.`appSystems` (
    `idAppSystem` INT NOT NULL AUTO_INCREMENT,
    `idCustomer` INT NULL, 
    `branch` VARCHAR(20) NULL, 
    `placeName` VARCHAR(255) NULL, 
    `img1` VARCHAR(255) NULL, 
    `img2` VARCHAR(255) NULL, 
    `img3` VARCHAR(255) NULL, 
    `img4` VARCHAR(255) NULL, 
    `locationDescription` TEXT(1000) NULL, 
    `site` VARCHAR(255) NULL, 
    `locationPhone` VARCHAR(17) NULL, 
    `idAddress` INT NULL, 
    `idServiceHour` INT NULL, 
    `idStatistic` INT NULL, 
    `idOption` INT NULL,          
    `date` TIMESTAMP(2) NULL,  
    PRIMARY KEY (`idAppSystem`)
  );


INSERT INTO `saoRoqueVoce`.`roots` (`rootName`, `userName`, `type`, `email`, `password`, `data`) VALUES ('Nome Sobrenome e o que tiver', 'Meu-Nome_usuario', '3', 'sandrosa0315@gmail.com', 'senhacriptografada', '2021-10-03 20:35:03.00');

 






-- ////////////////////////////////////////////////////////////CLIENTES/////////////////////////////////////////////////////--


  CREATE TABLE IF NOT EXISTS `sistema`.`customer` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(90) NOT NULL,
  `cpf` VARCHAR(14) NULL,
  `email` varchar(255) NOT NULL,
  `phone` VARCHAR(15) NULL,
  `password` varchar(90) NOT NULL,
  `birthDate` varchar(15) NOT NULL,
  `createDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `permission` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

-- Exemplo
 INSERT INTO `sistema`.`customer` (`name`, `cpf`, `email`, `phone`, `password`, `birthdate`, `createDate`, `permission`, `status`) VALUES
  ('Sandro', '288.666.888-33', 'sandrosa1@gmail.com', '(11)95154-3859', '123', '15/03/1976', '2021-10-24 22:28:18', 'user', 'confirmation');

  CREATE TABLE IF NOT EXISTS `sistema`.`attempt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) CHARACTER SET latin1 NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `sistema`.`confirmation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(90) NOT NULL,
  `token` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;