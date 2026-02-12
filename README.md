# Learner Progress Dashboard - Coding Challenge

A full-stack Laravel application for tracking and managing learner progress across various courses.

## Features
- **Dashboard Overview**: View all learners, their enrolled courses, and completion progress.
- **Course Filtering**: Filter learners by specific course names to focus on target student groups.
- **Progress Sorting**: Sort the list by progress percentage (highest/lowest).

## Getting Started

Follow these instructions to get the project up and running on a Linux machine.

### Installation

1. **Clone the repository**.
2. **Install dependencies**:
   ```bash
   composer install
   ```
3. **Set up environment**:
   ```bash
   cp .env.example .env
   ```
4. **Prepare the database**:
   The project uses a SQLite database named `school_system` located in the project root.
   ```bash
   touch school_system
   php artisan migrate --seed
   ```
5. **Generate application key**:
   ```bash
   php artisan key:generate
   ```
6. **Start the server**:
   ```bash
   php artisan serve
   ```

The application will be accessible at `http://localhost:8000/learner-progress`.

## Technical Choices
- **Tailwind CSS (via CDN)**: Used for rapid UI development without requiring a full Node.js build step.
- **Eloquent Eager Loading**: Utilized `with(['enrolments.course'])` to avoid N+1 query issues.
- **Filtering & Sorting**: Implemented on the server side to handle data efficiently.