# Cahier de recette - CESIZen

## 1. Objet du document

Ce cahier de recette definit la strategie, les cas de tests et les criteres d'acceptation de l'application CESIZen avant validation finale.

## 2. Perimetre de recette

Fonctionnalites incluses:

- Authentification et gestion de compte
- Gestion du profil
- Consultation des informations
- Diagnostic de stress
- Respiration guidee
- Historique utilisateur
- Administration (users, contenus, questions de stress)

Hors perimetre:

- Performance de charge a grande echelle
- Compatibilite navigateurs legacy
- Integration SSO

## 3. Environnements et pre-requis

- Application deployee en environnement de test
- Base de donnees initialisee avec migrations et seeders
- Comptes de test disponibles
- Navigateur web moderne

Jeux de comptes proposes:

- Admin: admin@cesizen.local / password
- Utilisateur standard: test@example.com / password

## 4. Strategie de recette

- Recette fonctionnelle manuelle basee sur scenarios metier.
- Verification des droits d'acces (admin vs user vs guest).
- Verification des validations formulaires.
- Verification des regles metier du diagnostic.
- Verification du parcours de bout en bout utilisateur.

## 5. Criteres de validation globaux

- 100% des cas critiques (bloquants) passent.
- Aucun bug de niveau critique ou majeur ouvert.
- Les regles metier du score stress sont conformes.
- Les droits d'acces sont conformes aux roles.

## 6. Grille des cas de test

## CT-001 - Inscription utilisateur

- Priorite: Haute
- Precondition: Etre deconnecte
- Etapes:
  1. Ouvrir la page d'inscription
  2. Renseigner nom, email, mot de passe conforme, confirmation
  3. Valider
- Resultat attendu:
  - Compte cree
  - Utilisateur connecte
  - Redirection vers tableau de bord

## CT-002 - Connexion utilisateur actif

- Priorite: Haute
- Precondition: Compte actif existant
- Etapes:
  1. Ouvrir la page de connexion
  2. Saisir email/mot de passe corrects
  3. Valider
- Resultat attendu:
  - Connexion reussie
  - Session ouverte
  - Redirection vers dashboard

## CT-003 - Connexion utilisateur desactive

- Priorite: Haute
- Precondition: Compte existe avec is_active = false
- Etapes:
  1. Tenter de se connecter avec identifiants valides
- Resultat attendu:
  - Connexion refusee
  - Message: compte desactive

## CT-004 - Mot de passe non conforme a la politique

- Priorite: Haute
- Precondition: Etre sur inscription ou changement mot de passe
- Etapes:
  1. Saisir un mot de passe trop court ou sans complexite
  2. Soumettre
- Resultat attendu:
  - Erreur de validation affichee
  - Mot de passe non enregistre

## CT-005 - Acces contenus publics

- Priorite: Moyenne
- Precondition: Aucune
- Etapes:
  1. Ouvrir la liste des informations
  2. Ouvrir un contenu publie
- Resultat attendu:
  - Liste visible
  - Detail visible

## CT-006 - Diagnostic guest sans persistance

- Priorite: Haute
- Precondition: Etre non connecte
- Etapes:
  1. Ouvrir diagnostic
  2. Cocher plusieurs evenements
  3. Valider
- Resultat attendu:
  - Score calcule et affiche
  - Niveau de stress affiche
  - Pas d'enregistrement en base pour ce guest

## CT-007 - Diagnostic utilisateur avec persistance

- Priorite: Haute
- Precondition: Utilisateur connecte
- Etapes:
  1. Ouvrir diagnostic
  2. Cocher des evenements
  3. Valider
- Resultat attendu:
  - Redirection historique
  - Diagnostic enregistre
  - Items de detail enregistres

## CT-008 - Classification stress faible

- Priorite: Haute
- Precondition: Utilisateur connecte
- Etapes:
  1. Selectionner des evenements totalisant un score <= 149
- Resultat attendu:
  - stress_level = faible

## CT-009 - Classification stress modere

- Priorite: Haute
- Precondition: Utilisateur connecte
- Etapes:
  1. Selectionner des evenements totalisant un score entre 150 et 299
- Resultat attendu:
  - stress_level = modere

## CT-010 - Classification stress eleve

- Priorite: Haute
- Precondition: Utilisateur connecte
- Etapes:
  1. Selectionner des evenements totalisant un score >= 300
- Resultat attendu:
  - stress_level = eleve
  - Recommendation respiration visible dans les ecrans concernes

## CT-011 - Respiration guidee utilisateur connecte

- Priorite: Haute
- Precondition: Utilisateur connecte
- Etapes:
  1. Ouvrir respiration
  2. Demarrer puis laisser finir la seance
- Resultat attendu:
  - Session de respiration enregistree
  - Message succes affiche

## CT-012 - Respiration guidee guest

- Priorite: Moyenne
- Precondition: Etre non connecte
- Etapes:
  1. Ouvrir respiration
  2. Faire une seance
- Resultat attendu:
  - Pas d'enregistrement en base
  - Invitation a se connecter visible

## CT-013 - Historique utilisateur

- Priorite: Haute
- Precondition: Utilisateur avec diagnostics existants
- Etapes:
  1. Ouvrir mes diagnostics
- Resultat attendu:
  - Liste paginee des diagnostics
  - Details des evenements
  - Historique respiration visible

## CT-014 - Acces admin interdit a un user standard

- Priorite: Haute
- Precondition: Connecte en user non admin
- Etapes:
  1. Tenter l'acces aux pages admin
- Resultat attendu:
  - Reponse 403 (interdit)

## CT-015 - Acces admin autorise a un admin

- Priorite: Haute
- Precondition: Connecte en admin
- Etapes:
  1. Ouvrir chaque module admin
- Resultat attendu:
  - Acces autorise

## CT-016 - CRUD contenus (admin)

- Priorite: Haute
- Precondition: Connecte en admin
- Etapes:
  1. Creer contenu
  2. Modifier contenu
  3. Publier/depublier
  4. Supprimer contenu
- Resultat attendu:
  - Operations reussies
  - Slug unique garanti

## CT-017 - CRUD questions stress (admin)

- Priorite: Haute
- Precondition: Connecte en admin
- Etapes:
  1. Creer question
  2. Modifier question
  3. Desactiver/supprimer question
- Resultat attendu:
  - Operations conformes
  - Validation score et unicite label respectees

## CT-018 - Gestion utilisateurs (admin)

- Priorite: Haute
- Precondition: Connecte en admin
- Etapes:
  1. Changer role d'un utilisateur
  2. Activer/desactiver un utilisateur
  3. Tenter de desactiver son propre compte admin
- Resultat attendu:
  - Mise a jour possible
  - Auto-desactivation admin refusee avec message explicite

## 7. Matrice de suivi

Pour chaque cas CT:

- Statut: A faire / OK / KO / Bloque
- Date execution
- Testeur
- Version application
- Numero anomalie associee (si KO)

## 8. Gestion des anomalies

Niveaux de severite:

- Critique: blocage complet d'une fonctionnalite critique
- Majeure: fonctionnalite degradee sans contournement simple
- Mineure: anomalie cosmetique ou contournable

Cycle:

1. Declaration anomalie
2. Qualification severite/priorite
3. Correction
4. Re-test
5. Cloture

## 9. PV de recette (modele)

- Projet: CESIZen
- Version testee: ................
- Date debut recette: ................
- Date fin recette: ................
- Nombre de cas executes: ................
- Nombre OK: ................
- Nombre KO: ................
- Nombre bloques: ................
- Nombre anomalies critiques ouvertes: ................
- Decision finale: GO / NO GO
- Commentaires:

Signataires:

- Responsable metier: ................
- Responsable technique: ................
- Testeur principal: ................

## 10. Conclusion

Ce cahier de recette permet de valider de maniere structuree les exigences fonctionnelles et de securite de CESIZen avant livraison finale.