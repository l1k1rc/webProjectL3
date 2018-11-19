-- DROP TABLE Users;

CREATE TABLE Users
(
  emailU character(50) NOT NULL,
  nameU character varying(30) NOT NULL,
  surnameU character varying(30) NOT NULL,
  ageU integer,
  gender character(30),
  phoneU character(20),
  passwordU character varying(50),
  profilimgu character varying(60),
  CONSTRAINT Users_pkey PRIMARY KEY (emailU)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE Users
  OWNER TO l1k1;

  -- DROP TABLE Rent;

CREATE TABLE Rent
(
  idRent serial,
  typeRent character varying(30) NOT NULL,
  kilometerRent integer NOT NULL,
  conditionRent character varying(35),
  nameRent character varying(40),
  serieRent character varying(30),
  brandRent character varying(30),
  availabilityRent character(30),
  priceRent float,
  horsePowerRent integer,
  possibilityRent boolean,
  gearboxRent character varying(20),
  nbr_seatRent integer,
  fuel_typeRent character varying(20),
  nbr_doorRent integer,
  descriptionRent text,
  emailU character(50),
  CONSTRAINT Rent_pkey PRIMARY KEY (idRent),
   CONSTRAINT Rent_emailU_fkey FOREIGN KEY (emailU)
      REFERENCES Users (emailU) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE Rent
  OWNER TO l1k1;



  -- DROP TABLE Warehouse;

CREATE TABLE Warehouse
(
  id_accountWh serial,
  balanceWh float NOT NULL,
  date_exchangeWh date,
  emailU character(50),
  CONSTRAINT Warehouse_pkey PRIMARY KEY (id_accountWh),
   CONSTRAINT Warehouse_emailU_fkey FOREIGN KEY (emailU)
      REFERENCES Users (emailU) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE Warehouse
  OWNER TO l1k1;


  -- DROP TABLE Files;

CREATE TABLE Files
(	
  id_files serial,
  path_photoFiles character varying(100),
  date_createFiles date,
  idRent integer,
  CONSTRAINT Files_pkey PRIMARY KEY (id_files),
  CONSTRAINT Files_idRent_fkey FOREIGN KEY (idRent)
      REFERENCES Rent (idRent) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE Files
  OWNER TO l1k1;


  
  -- DROP TABLE Historical;

CREATE TABLE Historical
(
  id_transactionH serial,
  dateH date,
  typeH character(30),
  idRent integer,
  emailU character(50),
  CONSTRAINT Historical_pkey PRIMARY KEY (id_transactionH),
   CONSTRAINT Historical_idRent_fkey FOREIGN KEY (idRent)
      REFERENCES Rent (idRent) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
   CONSTRAINT Historical_emailU_fkey FOREIGN KEY (emailU)
      REFERENCES Users (emailU) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
  
)
WITH (
  OIDS=FALSE
);
ALTER TABLE Historical
  OWNER TO l1k1;

    -- DROP TABLE Whisper;

CREATE TABLE Whisper
(
  idWhisper serial,
  messageWhisp text,
  dateWhisp date,
  srcWhisp character varying(40),
  dstWhisp character varying(40),
  emailU character(50),
  idA integer,
  CONSTRAINT Whisper_pkey PRIMARY KEY (idWhisper)
  
)
WITH (
  OIDS=FALSE
);
ALTER TABLE Whisper
  OWNER TO l1k1;



    -- DROP TABLE Admins;

CREATE TABLE Admins
(
  idA serial,
  pseudoA character varying(40),
  passwordA character varying(40),
  CONSTRAINT Admins_pkey PRIMARY KEY (idA)
  
)
WITH (
  OIDS=FALSE
);
ALTER TABLE Admins
  OWNER TO l1k1;


    -- DROP TABLE Estimate;

CREATE TABLE Estimate
(
  id_commentEst serial,
  dateEst date,
  notationEst integer,
  commentEst text,
  emailU character(50),
  titleest character varying(50),
  idrent integer,
  CONSTRAINT Estimate_pkey PRIMARY KEY (id_commentEst),
   CONSTRAINT Estimate_emailU_fkey FOREIGN KEY (emailU)
      REFERENCES Users (emailU) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
   CONSTRAINT Estimate_idrent_fkey FOREIGN KEY (idrent)
      REFERENCES rent (idrent) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE Estimate
  OWNER TO l1k1;

    -- DROP TABLE Estimate;

CREATE TABLE Statistic
(
  nbr_UserS integer NOT NULL,
  nbr_rentals integer,
  nbr_carshare integer,
  locationS character varying(40),
  emailU character(50) NOT NULL,
  --idRent character(30) NOT NULL,
  --idCarshare character(30) NOT NULL,
  
  CONSTRAINT Statistic_pkey PRIMARY KEY (nbr_userS),
   CONSTRAINT Statistics_emailU_fkey FOREIGN KEY (emailU)
      REFERENCES Users (emailU) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
   --CONSTRAINT Statistics_idRent_fkey FOREIGN KEY (idRent)
      --REFERENCES Rent (idRent) MATCH SIMPLE
      --ON UPDATE NO ACTION ON DELETE NO ACTION,
    --CONSTRAINT Statistics_idCarshare_fkey FOREIGN KEY (idCarshare)
      --REFERENCES CarShare (idCarshare) MATCH SIMPLE
      --ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE Statistic
  OWNER TO l1k1;

CREATE TABLE File2
(
  idFiles2 serial,
  path2photofiles character varying(150) NOT NULL,
  idRent integer,
  
  CONSTRAINT File2_pkey PRIMARY KEY (idFiles2),
   CONSTRAINT Files2_idRent_fkey FOREIGN KEY (idRent)
      REFERENCES Rent (idRent) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE File2
  OWNER TO l1k1;

  