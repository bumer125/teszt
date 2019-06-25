--Database
CREATE DATABASE workout
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Hungarian_Hungary.1250'
    LC_CTYPE = 'Hungarian_Hungary.1250'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;
---------------------------------------------------------------------------------------------------------------------------------------------------------------
--create tables
CREATE TABLE public."user"
(
    id integer NOT NULL DEFAULT nextval('user_id_seq'::regclass) ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    username character varying COLLATE pg_catalog."default",
    nfirst character varying COLLATE pg_catalog."default",
    nsecond character varying COLLATE pg_catalog."default",
    CONSTRAINT user_pkey PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public."user"
    OWNER to postgres;
	
CREATE TABLE public.bodypart
(
    id integer NOT NULL DEFAULT nextval('bodypart_id_seq'::regclass) ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    name character varying COLLATE pg_catalog."default",
    userid integer,
    img bytea,
    CONSTRAINT bodypart_pkey PRIMARY KEY (id),
    CONSTRAINT userid FOREIGN KEY (userid)
        REFERENCES public."user" (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.bodypart
    OWNER to postgres;

-- Index: fki_userid

-- DROP INDEX public.fki_userid;

CREATE INDEX fki_userid
    ON public.bodypart USING btree
    (userid)
    TABLESPACE pg_default;
	
CREATE TABLE public.exercise
(
    id integer NOT NULL DEFAULT nextval('exercise_id_seq'::regclass) ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1 ),
    name character varying COLLATE pg_catalog."default",
    run character varying COLLATE pg_catalog."default",
    repeat character varying COLLATE pg_catalog."default",
    img bytea,
    bodyid integer,
    CONSTRAINT exercise_pkey PRIMARY KEY (id),
    CONSTRAINT bodyid FOREIGN KEY (bodyid)
        REFERENCES public.bodypart (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.exercise
    OWNER to postgres;

-- Index: fki_bodyid

-- DROP INDEX public.fki_bodyid;

CREATE INDEX fki_bodyid
    ON public.exercise USING btree
    (bodyid)
    TABLESPACE pg_default;
	
---------------------------------------------------------------------------------------------------------------------------------------------------------------