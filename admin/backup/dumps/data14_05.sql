--
-- PostgreSQL database dump
--

-- Dumped from database version 16.3
-- Dumped by pg_dump version 16.3

-- Started on 2024-05-14 10:45:44

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 4 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA public;


--
-- TOC entry 4841 (class 0 OID 0)
-- Dependencies: 4
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON SCHEMA public IS 'standard public schema';


--
-- TOC entry 227 (class 1255 OID 24589)
-- Name: ajout_admin(text, text); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION public.ajout_admin(text, text) RETURNS integer
    LANGUAGE plpgsql
    AS '
  declare p_nom alias for $1;
  declare p_password alias for $2;
  declare id integer;
  declare retour integer;
  
  begin
  	select into id id_admin from admin where nom_admin = p_nom and password = p_password;
	if not found
	then
	  insert into admin (nom_admin,password) values (p_nom,p_password);
	  if not found
	  then
	  
	    retour = -1; -- échec insertion
	  else
	    retour = 1; -- insertion réussie
	  end if;
	else
	  retour = 0; --déjà en BD
	end if;
	
	return retour;
end;
';


--
-- TOC entry 231 (class 1255 OID 24590)
-- Name: ajout_client(text, text, text, text, text); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION public.ajout_client(text, text, text, text, text) RETURNS integer
    LANGUAGE plpgsql
    AS '
  declare p_nom alias for $1;
  declare p_prenom alias for $2;
  declare p_email alias for $3;
  declare p_adresse alias for $4;
  declare p_numero alias for $5;
  declare id integer;
  declare retour integer;
  
begin
	select into id id_client from client where email = p_email;
	if not found
	then
	  insert into client (nom,prenom,email,adresse,numero) values
	    (p_nom,p_prenom,p_email,p_adresse,p_numero);
	  select into id id_client from client where email = p_email;
	  if not found
	  then	
	    retour = -1;  --échec de la requête
	  else
	    retour = 1;   -- insertion ok
	  end if;
	else
	  retour = 0;      -- déjà en BD
	end if;
 return retour;
 end;
';


--
-- TOC entry 232 (class 1255 OID 24604)
-- Name: delete_client(text); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION public.delete_client(text) RETURNS integer
    LANGUAGE plpgsql
    AS 'declare p_email alias for $1;
declare retour integer;
BEGIN
    SELECT COUNT(*) INTO retour FROM client WHERE email = p_email;
    
    IF retour = 0 THEN
        RETURN 0; -- Le client n''existe pas dans la base de données
    ELSE
        DELETE FROM client WHERE email = p_email;
        
        SELECT COUNT(*) INTO retour FROM client WHERE email = p_email;
        
        IF retour = 0 THEN
            RETURN 1; -- Suppression réussie
        ELSE
            RETURN -1; -- La suppression a échoué
        END IF;
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        -- Gérer les erreurs ici, par exemple, en enregistrant le message d''erreur dans une table de journal
        RAISE NOTICE ''Une erreur s''''est produite : %'', SQLERRM;
        RETURN -2; -- Valeur de retour pour indiquer une erreur
END;';


--
-- TOC entry 228 (class 1255 OID 24591)
-- Name: getalladmintest1(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION public.getalladmintest1() RETURNS TABLE(id integer, nom text, email text)
    LANGUAGE plpgsql
    AS '
BEGIN
  RETURN QUERY
  SELECT * FROM admin;
END;
';


--
-- TOC entry 229 (class 1255 OID 24592)
-- Name: getalladmintest2(); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION public.getalladmintest2() RETURNS SETOF record
    LANGUAGE plpgsql
    AS '
BEGIN
  RETURN QUERY SELECT id_admin, nom_admin, password FROM admin;
END;
';


--
-- TOC entry 230 (class 1255 OID 24593)
-- Name: verifier_admin(text, text); Type: FUNCTION; Schema: public; Owner: -
--

CREATE FUNCTION public.verifier_admin(text, text) RETURNS integer
    LANGUAGE plpgsql
    AS '
  DECLARE p_login ALIAS FOR $1;
  DECLARE p_pass ALIAS for $2;
  DECLARE id integer;
  DECLARE retour integer;
BEGIN
  select into id id_admin from admin where nom_admin = p_login and password = p_pass;
  IF NOT FOUND
  THEN
    retour = 0;
  ELSE
    retour = 1;
  END IF;
   return retour;
 end;
  
';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 224 (class 1259 OID 24594)
-- Name: admin; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.admin (
    id_admin integer NOT NULL,
    nom_admin text NOT NULL,
    password text NOT NULL
);


--
-- TOC entry 225 (class 1259 OID 24599)
-- Name: admin_id_admin_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.admin_id_admin_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 4842 (class 0 OID 0)
-- Dependencies: 225
-- Name: admin_id_admin_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.admin_id_admin_seq OWNED BY public.admin.id_admin;


--
-- TOC entry 226 (class 1259 OID 24602)
-- Name: admin_id_admin_seq1; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.admin ALTER COLUMN id_admin ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.admin_id_admin_seq1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 218 (class 1259 OID 16473)
-- Name: client; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.client (
    id_client integer NOT NULL,
    nom text NOT NULL,
    prenom text NOT NULL,
    email text NOT NULL,
    adresse character varying(50) NOT NULL,
    numero text NOT NULL,
    password text
);


--
-- TOC entry 220 (class 1259 OID 16497)
-- Name: client_id_client_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.client ALTER COLUMN id_client ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.client_id_client_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 216 (class 1259 OID 16451)
-- Name: film; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.film (
    id_film integer NOT NULL,
    titre_film text NOT NULL,
    description_film text,
    genre_film text,
    real_film text NOT NULL,
    duree_film double precision,
    affiche_film text NOT NULL,
    date_sortie date NOT NULL
);


--
-- TOC entry 221 (class 1259 OID 16498)
-- Name: film_id_film_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.film ALTER COLUMN id_film ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.film_id_film_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 215 (class 1259 OID 16446)
-- Name: salle; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.salle (
    numero_salle integer NOT NULL,
    "nombre_de_siège" integer NOT NULL
);


--
-- TOC entry 217 (class 1259 OID 16458)
-- Name: sceance; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.sceance (
    id_sceance integer NOT NULL,
    heure_debut date NOT NULL,
    heure_fin date NOT NULL,
    id_film integer NOT NULL,
    numero_salle integer NOT NULL
);


--
-- TOC entry 222 (class 1259 OID 16499)
-- Name: sceance_id_sceance_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.sceance ALTER COLUMN id_sceance ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.sceance_id_sceance_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 219 (class 1259 OID 16480)
-- Name: ticket; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.ticket (
    id_ticket integer NOT NULL,
    quantite integer NOT NULL,
    prix numeric NOT NULL,
    id_client integer NOT NULL,
    id_sceance integer NOT NULL
);


--
-- TOC entry 223 (class 1259 OID 16500)
-- Name: ticket_id_ticket_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.ticket ALTER COLUMN id_ticket ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.ticket_id_ticket_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 4833 (class 0 OID 24594)
-- Dependencies: 224
-- Data for Name: admin; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.admin (id_admin, nom_admin, password) OVERRIDING SYSTEM VALUE VALUES (1, 'romain', '123');


--
-- TOC entry 4827 (class 0 OID 16473)
-- Dependencies: 218
-- Data for Name: client; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.client (id_client, nom, prenom, email, adresse, numero, password) OVERRIDING SYSTEM VALUE VALUES (9, '0', '0', '0', '0', 'ouiii', NULL);


--
-- TOC entry 4825 (class 0 OID 16451)
-- Dependencies: 216
-- Data for Name: film; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.film (id_film, titre_film, description_film, genre_film, real_film, duree_film, affiche_film, date_sortie) OVERRIDING SYSTEM VALUE VALUES (1, 'Inception', 'Un voleur expérimenté doit entrer dans les rêves d''une cible pour lui voler des secrets.', 'Science-fiction, Action', 'Christopher Nolan', 148, 'inception.jpg', '2010-07-16');
INSERT INTO public.film (id_film, titre_film, description_film, genre_film, real_film, duree_film, affiche_film, date_sortie) OVERRIDING SYSTEM VALUE VALUES (2, 'The Dark Knight', 'Batman affronte le Joker dans une lutte pour le destin de Gotham City.', 'Action, Crime, Drame', 'Christopher Nolan', 152, 'dark_knight.jpg', '2008-07-18');
INSERT INTO public.film (id_film, titre_film, description_film, genre_film, real_film, duree_film, affiche_film, date_sortie) OVERRIDING SYSTEM VALUE VALUES (3, 'The Shawshank Redemption', 'Deux hommes condamnés à la prison à vie se lient d''amitié et trouvent l''espoir dans des circonstances désespérées.', 'Drame', 'Frank Darabont', 142, 'shawshank_redemption.jpg', '1994-10-14');
INSERT INTO public.film (id_film, titre_film, description_film, genre_film, real_film, duree_film, affiche_film, date_sortie) OVERRIDING SYSTEM VALUE VALUES (4, 'The Godfather', 'Un parrain de la mafia transfère le contrôle de son empire criminel à son fils.', 'Crime, Drame', 'Francis Ford Coppola', 175, 'godfather.jpg', '1972-03-24');
INSERT INTO public.film (id_film, titre_film, description_film, genre_film, real_film, duree_film, affiche_film, date_sortie) OVERRIDING SYSTEM VALUE VALUES (5, 'Pulp Fiction', 'Les histoires entrelacées de plusieurs criminels à Los Angeles.', 'Crime, Drame', 'Quentin Tarantino', 154, 'pulp_fiction.jpg', '1994-10-14');
INSERT INTO public.film (id_film, titre_film, description_film, genre_film, real_film, duree_film, affiche_film, date_sortie) OVERRIDING SYSTEM VALUE VALUES (6, 'The Lord of the Rings: The Fellowship of the Ring', 'Un jeune hobbit entreprend un voyage épique pour détruire un anneau maléfique.', 'Aventure, Fantaisie', 'Peter Jackson', 178, 'lord_of_the_rings_fellowship.jpg', '2001-12-19');
INSERT INTO public.film (id_film, titre_film, description_film, genre_film, real_film, duree_film, affiche_film, date_sortie) OVERRIDING SYSTEM VALUE VALUES (7, 'Forrest Gump', 'Les aventures d''un homme simple d''esprit à travers des moments clés de l''histoire américaine.', 'Drame, Romance', 'Robert Zemeckis', 142, 'forrest_gump.jpg', '1994-07-06');
INSERT INTO public.film (id_film, titre_film, description_film, genre_film, real_film, duree_film, affiche_film, date_sortie) OVERRIDING SYSTEM VALUE VALUES (8, 'The Matrix', 'Un hacker découvre la vérité sur la réalité et sa lutte pour libérer l''humanité d''une simulation informatique.', 'Action, Science-fiction', 'The Wachowskis', 136, 'matrix.jpg', '1999-03-31');
INSERT INTO public.film (id_film, titre_film, description_film, genre_film, real_film, duree_film, affiche_film, date_sortie) OVERRIDING SYSTEM VALUE VALUES (9, 'Star Wars: Episode IV - A New Hope', 'Un jeune fermier se lance dans une aventure intergalactique pour sauver la galaxie de l''Empire.', 'Aventure, Fantaisie', 'George Lucas', 121, 'star_wars_a_new_hope.jpg', '1977-05-25');
INSERT INTO public.film (id_film, titre_film, description_film, genre_film, real_film, duree_film, affiche_film, date_sortie) OVERRIDING SYSTEM VALUE VALUES (10, 'Titanic', 'L''histoire d''amour tragique entre un passager de première classe et un artiste pauvre à bord du RMS Titanic.', 'Drame, Romance', 'James Cameron', 195, 'titanic.jpg', '1997-12-19');
INSERT INTO public.film (id_film, titre_film, description_film, genre_film, real_film, duree_film, affiche_film, date_sortie) OVERRIDING SYSTEM VALUE VALUES (11, 'The Silence of the Lambs', 'Une jeune stagiaire du FBI consulte un psychopathe cannibale pour attraper un tueur en série.', 'Crime, Drame, Horreur', 'Jonathan Demme', 118, 'silence_of_the_lambs.jpg', '1991-02-14');
INSERT INTO public.film (id_film, titre_film, description_film, genre_film, real_film, duree_film, affiche_film, date_sortie) OVERRIDING SYSTEM VALUE VALUES (12, 'The Avengers', 'Des super-héros s''unissent pour contrer une menace extraterrestre.', 'Action, Aventure, Science-fiction', 'Joss Whedon', 143, 'avengers.jpg', '2012-04-11');
INSERT INTO public.film (id_film, titre_film, description_film, genre_film, real_film, duree_film, affiche_film, date_sortie) OVERRIDING SYSTEM VALUE VALUES (13, 'Jurassic Park', 'Des scientifiques découvrent un parc à thème peuplé de dinosaures génétiquement reproduits.', 'Aventure, Science-fiction', 'Steven Spielberg', 127, 'jurassic_park.jpg', '1993-06-11');
INSERT INTO public.film (id_film, titre_film, description_film, genre_film, real_film, duree_film, affiche_film, date_sortie) OVERRIDING SYSTEM VALUE VALUES (14, 'Gladiator', 'Un général romain déchu cherche à se venger du meurtre de sa famille en participant à des jeux de gladiateurs.', 'Action, Aventure, Drame', 'Ridley Scott', 155, 'gladiator.jpg', '2000-05-05');
INSERT INTO public.film (id_film, titre_film, description_film, genre_film, real_film, duree_film, affiche_film, date_sortie) OVERRIDING SYSTEM VALUE VALUES (15, 'The Social Network', 'L''histoire de la création tumultueuse de Facebook par Mark Zuckerberg.', 'Biographie, Drame', 'David Fincher', 120, 'social_network.jpg', '2010-10-01');


--
-- TOC entry 4824 (class 0 OID 16446)
-- Dependencies: 215
-- Data for Name: salle; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 4826 (class 0 OID 16458)
-- Dependencies: 217
-- Data for Name: sceance; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 4828 (class 0 OID 16480)
-- Dependencies: 219
-- Data for Name: ticket; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 4843 (class 0 OID 0)
-- Dependencies: 225
-- Name: admin_id_admin_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.admin_id_admin_seq', 1, false);


--
-- TOC entry 4844 (class 0 OID 0)
-- Dependencies: 226
-- Name: admin_id_admin_seq1; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.admin_id_admin_seq1', 1, true);


--
-- TOC entry 4845 (class 0 OID 0)
-- Dependencies: 220
-- Name: client_id_client_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.client_id_client_seq', 9, true);


--
-- TOC entry 4846 (class 0 OID 0)
-- Dependencies: 221
-- Name: film_id_film_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.film_id_film_seq', 15, true);


--
-- TOC entry 4847 (class 0 OID 0)
-- Dependencies: 222
-- Name: sceance_id_sceance_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.sceance_id_sceance_seq', 1, false);


--
-- TOC entry 4848 (class 0 OID 0)
-- Dependencies: 223
-- Name: ticket_id_ticket_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.ticket_id_ticket_seq', 1, false);


--
-- TOC entry 4676 (class 2606 OID 24601)
-- Name: admin admin_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.admin
    ADD CONSTRAINT admin_pkey PRIMARY KEY (id_admin);


--
-- TOC entry 4672 (class 2606 OID 16479)
-- Name: client client_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.client
    ADD CONSTRAINT client_pkey PRIMARY KEY (id_client);


--
-- TOC entry 4668 (class 2606 OID 16457)
-- Name: film film_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.film
    ADD CONSTRAINT film_pkey PRIMARY KEY (id_film);


--
-- TOC entry 4666 (class 2606 OID 16450)
-- Name: salle salle_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.salle
    ADD CONSTRAINT salle_pkey PRIMARY KEY (numero_salle);


--
-- TOC entry 4670 (class 2606 OID 16462)
-- Name: sceance sceance_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sceance
    ADD CONSTRAINT sceance_pkey PRIMARY KEY (id_sceance);


--
-- TOC entry 4674 (class 2606 OID 16486)
-- Name: ticket ticket_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.ticket
    ADD CONSTRAINT ticket_pkey PRIMARY KEY (id_ticket);


--
-- TOC entry 4677 (class 2606 OID 16463)
-- Name: sceance sceance_id_film_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sceance
    ADD CONSTRAINT sceance_id_film_fkey FOREIGN KEY (id_film) REFERENCES public.film(id_film);


--
-- TOC entry 4678 (class 2606 OID 16468)
-- Name: sceance sceance_numero_salle_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sceance
    ADD CONSTRAINT sceance_numero_salle_fkey FOREIGN KEY (numero_salle) REFERENCES public.salle(numero_salle);


--
-- TOC entry 4679 (class 2606 OID 16487)
-- Name: ticket ticket_id_client_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.ticket
    ADD CONSTRAINT ticket_id_client_fkey FOREIGN KEY (id_client) REFERENCES public.client(id_client);


--
-- TOC entry 4680 (class 2606 OID 16492)
-- Name: ticket ticket_id_sceance_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.ticket
    ADD CONSTRAINT ticket_id_sceance_fkey FOREIGN KEY (id_sceance) REFERENCES public.sceance(id_sceance);


-- Completed on 2024-05-14 10:45:46

--
-- PostgreSQL database dump complete
--

