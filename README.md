
# My Quiz

## Introduction

My Quiz is a web application that allows users to test their general knowledge through quizzes. Users can select categories and answer a series of questions, they can also create their own quiz. Admins can manage (CRUD) users, categories, quizzes and answers.

## Project Setup

**Requirements:**
- PHP >= 8.2
- Symfony >= 3.0
- Other dependencies as listed in `composer.json`

**Installation:**

1. Clone the repository:
    ```bash
    git clone <repository_url>
    cd my_quiz
    ```

2. Install dependencies:
    ```bash
    composer install
    ```

3. Set up the environment:
    ```bash
    cp .env.example .env
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```

4. Start the server:
    ```bash
    symfony server:start
    ```

## Features

**User Features:**
- Answer quizzes
- View quiz history and scores
- Register and login
- Change email and password (with email revalidation)
- Create new quizzes

**Admin Features:**
- Manage user accounts
- Manage categories and quizzes
