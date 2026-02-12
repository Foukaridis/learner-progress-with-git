# Learner Progress Dashboard - Coding Challenge

A modern, reactive full-stack Laravel application for tracking and managing learner progress across various courses.

## Features
- **Dashboard Overview**: View all learners, their enrolled courses, and completion progress.
- **Course Filtering**: Filter learners by specific course names to focus on target student groups.
- **Progress Sorting**: Sort the list by progress percentage (highest/lowest).

## Getting Started

Follow these instructions to get the project up and running on your machine.

### Prerequisites
- PHP ^8.2
- Node.js & NPM
- Composer

### Installation

1. **Clone the repository and check out the relevant branch - main / vue**:
   ```bash
   git clone https://github.com/Foukaridis/learner-progress-with-git.git
   cd learner-progress-with-git
   git checkout main
   ```
2. **Install PHP dependencies**:
   ```bash
   composer install
   ```
3. **Install JavaScript dependencies** (only for vue branch):
   ```bash
   npm install
   ```
4. **Set up environment**:
   ```bash
   cp .env.example .env
   ```
   Then fill in the database credentials.

5. **Generate application key**:
   ```bash
   php artisan key:generate
   ```
6. **Prepare the database**:
   The project uses a SQLite database named `school_system` located in the root.
   ```bash
   touch school_system
   php artisan migrate --seed
   ```
### Running the Application

To run the application, you need to start both the PHP server and the Vite development server.

1. **Start the Laravel server**:
   ```bash
   php artisan serve
   ```
2. **Start the Vite development server**  (only for vue branch):
   ```bash
   npm run dev
   ```

The application will be accessible at `http://localhost:8000/learner-progress`.

## Technical Choices
- **Tailwind CSS**: Integrated via Vite for premium, utility-first styling.
- **Eloquent Eager Loading**: Utilizes `with(['enrolments.course'])` to ensure high performance and avoid N+1 queries.
