# Learner Progress Dashboard - Coding Challenge

A modern, reactive full-stack Laravel application for tracking and managing learner progress across various courses.

## Features
- **Reactive Dashboard**: Powered by Vue.js and Inertia.js for a seamless Single Page Application (SPA) experience.
- **Dynamic Views**: Toggle between card and table layouts instantly.
- **Course Filtering**: Filter learners by specific course names with automatic state preservation.
- **Progress Sorting**: Sort the list by progress percentage (highest/lowest) reactively.

## Getting Started

Follow these instructions to get the project up and running on your machine.

### Prerequisites
- PHP ^8.2
- Node.js & NPM
- Composer

### Installation

1. **Clone the repository**.
2. **Install PHP dependencies**:
   ```bash
   composer install
   ```
3. **Install JavaScript dependencies**:
   ```bash
   npm install
   ```
4. **Set up environment**:
   ```bash
   cp .env.example .env
   ```
5. **Prepare the database**:
   The project uses a SQLite database named `school_system` located in the root.
   ```bash
   touch school_system
   php artisan migrate --seed
   ```
6. **Generate application key**:
   ```bash
   php artisan key:generate
   ```

### Running the Application

To run the application, you need to start both the PHP server and the Vite development server.

1. **Start the Laravel server**:
   ```bash
   php artisan serve
   ```
2. **Start the Vite development server**:
   ```bash
   npm run dev
   ```

The application will be accessible at `http://localhost:8000/learner-progress`.

## Technical Choices
- **Vue.js 3**: Used to build a highly reactive and interactive user interface.
- **Inertia.js**: Bridges the gap between the Laravel backend and Vue frontend, providing a seamless SPA experience without the complexity of a client-side API.
- **Tailwind CSS**: Integrated via Vite for premium, utility-first styling.
- **Ziggy**: Provides Laravel's routing capabilities directly inside Vue components.
- **Eloquent Eager Loading**: Utilizes `with(['enrolments.course'])` to ensure high performance and avoid N+1 queries.