CREATE TABLE `carboncopy` (
    `id` INTEGER NOT NULL PRIMARY KEY,
    `ticket_id` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL
);

CREATE TABLE `comment` (
    `id` INTEGER NOT NULL PRIMARY KEY,
    `action` TEXT,
    `text` TEXT NOT NULL,
    `ticket_id` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    `creation` TEXT NOT NULL,
    `change` TEXT DEFAULT NULL
);


CREATE TABLE `email` (
    `id` INTEGER NOT NULL PRIMARY KEY,
    `user_id` INTEGER NOT NULL,
    `address` TEXT NOT NULL,
    `creation` TEXT NOT NULL,
    `change` TEXT DEFAULT NULL
);

CREATE TABLE `member` (
    `id` INTEGER NOT NULL PRIMARY KEY,
    `user_id` INTEGER NOT NULL,
    `project_id` INTEGER NOT NULL,
    `creation` TEXT NOT NULL,
    `change` TEXT DEFAULT NULL
);

CREATE TABLE `milestone` (
    `id` INTEGER NOT NULL PRIMARY KEY,
    `project_id` INTEGER NOT NULL,
    `name` TEXT NOT NULL,
    `description` TEXT,
    `ttd` TEXT NOT NULL,
    `creation` TEXT NOT NULL,
    `change` TEXT DEFAULT NULL
);

CREATE TABLE `project` (
    `id` INTEGER NOT NULL PRIMARY KEY,
    `name` TEXT  NOT NULL,
    `short` TEXT  NOT NULL,
    `description` TEXT  DEFAULT NULL,
    `slug` TEXT  NOT NULL,
    `rcs` TEXT  NOT NULL,
    `path` TEXT  NOT NULL,
    `acl` TEXT  NOT NULL,
    `creation` TEXT NOT NULL,
    `change` TEXT DEFAULT NULL
);

CREATE TABLE `role` (
    `id` INTEGER NOT NULL PRIMARY KEY,
    `member_id` INTEGER NOT NULL,
    `on` TEXT NOT NULL,
    `create` INTEGER NOT NULL DEFAULT 1,
    `read` INTEGER NOT NULL DEFAULT 1,
    `update` INTEGER NOT NULL DEFAULT 1,
    `delete` INTEGER NOT NULL DEFAULT 0,
    `creation` TEXT NOT NULL,
    `change` TEXT DEFAULT NULL
);

CREATE TABLE `tag` (
    `id` INTEGER NOT NULL PRIMARY KEY,
    `name` TEXT  NOT NULL,
    `slug` TEXT  NOT NULL,
    `belongsto` TEXT  NOT NULL,
    `attachedto` INTEGER NOT NULL
);

CREATE TABLE `ticket` (
    `id` INTEGER NOT NULL PRIMARY KEY,
    `project_id` INTEGER NOT NULL,
    `user_id` INTEGER DEFAULT NULL,
    `milestone_id` INTEGER DEFAULT NULL,
    `title` TEXT  NOT NULL,
    `text` TEXT  NOT NULL,
    `type` TEXT NOT NULL DEFAULT 'defect',
    `status` TEXT  NOT NULL DEFAULT 'open',
    `assignedto` INTEGER DEFAULT NULL,
    `priority` TEXT NOT NULL DEFAULT 'normal',
    `severity` TEXT NOT NULL DEFAULT 'normal',
    `creation` TEXT NOT NULL,
    `change` TEXT DEFAULT NULL
);

CREATE TABLE `user` (
    `id` INTEGER NOT NULL PRIMARY KEY,
    `login` TEXT  NOT NULL,
    `password` TEXT  NOT NULL,
    `nickname` TEXT  NOT NULL,
    `firstname` TEXT  DEFAULT NULL,
    `lastname` TEXT  DEFAULT NULL,
    `bio` TEXT  DEFAULT NULL,
    `image` BLOB,
    `creation` TEXT NOT NULL,
    `change` TEXT DEFAULT NULL
);

CREATE TABLE `wiki` (
    `id` INTEGER NOT NULL PRIMARY KEY,
    `title` TEXT  NOT NULL,
    `text` text ,
    `slug` TEXT  NOT NULL,
    `belongsto` TEXT DEFAULT NULL,
    `attachedto` INTEGER DEFAULT NULL,
    `user_id` INTEGER NOT NULL
);
