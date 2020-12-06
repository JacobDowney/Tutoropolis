# COMMANDS TO USE FOR CREATING DATABASE IN YOUR LOCAL SQL

// User table
CREATE TABLE User(
  userID      int(11) AUTO_INCREMENT NOT NULL,
  username    varchar(128) NOT NULL,
  password    varchar(128) NOT NULL,
  firstName   varchar(128) NOT NULL,
  lastName    varchar(128) NOT NULL,
  phoneNumber varchar(128) NOT NULL,
  email       varchar(128) NOT NULL,
  biography   text,
  PRIMARY KEY (userID)
);

// Subject table
CREATE TABLE Subject(
  subjectID   int(11) AUTO_INCREMENT NOT NULL,
  subject     varchar(128) NOT NULL,
  adminUserID int(11) NOT NULL,
  PRIMARY KEY (subjectID),
  FOREIGN KEY (adminUserID) REFERENCES User(userID)
);

// Tutoring Proposal table
CREATE TABLE TutoringProposal(
  tutoringProposalID  int(11) AUTO_INCREMENT NOT NULL,
  tutorUserID         int(11) NOT NULL,
  subjectID           int(11) NOT NULL,
  description         text,
  PRIMARY KEY         (tutoringProposalID),
  FOREIGN KEY         (tutorUserID) REFERENCES User(userID),
  FOREIGN KEY         (subjectID)   REFERENCES Subject(subjectID)
);

// Tutoring Session table
CREATE TABLE TutoringSession(
  sessionID     int(11) AUTO_INCREMENT NOT NULL,
  tutorUserID   int(11) NOT NULL,
  studentUserID int(11) NOT NULL,
  subjectID     int(11) NOT NULL,
  active        boolean NOT NULL,
  PRIMARY KEY   (sessionID),
  FOREIGN KEY   (tutorUserID)   REFERENCES User(userID),
  FOREIGN KEY   (studentUserID) REFERENCES User(userID),
  FOREIGN KEY   (subjectID)     REFERENCES Subject(subjectID)
);
