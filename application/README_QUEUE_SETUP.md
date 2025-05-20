# Queue Setup Instructions

## Issue
The application was configured to use Laravel's queue system with the database driver, but the required database tables were missing.

## Solution
1. Migration files have been created for the necessary tables:
   - `jobs` - Stores queued jobs
   - `failed_jobs` - Stores information about failed jobs
   - `job_batches` - Stores information about job batches

2. The `.env` file has been updated to set `QUEUE_CONNECTION=database`

## Required Actions
To complete the setup, you need to run the migrations to create the tables in the database:

```bash
cd /path/to/application
php artisan migrate
```

This will create the necessary tables in the database.

## Verifying the Setup
After running the migrations, you can verify that the tables have been created by checking the database:

```sql
SHOW TABLES LIKE 'jobs';
SHOW TABLES LIKE 'failed_jobs';
SHOW TABLES LIKE 'job_batches';
```

## Running the Queue Worker
To process the queued jobs, you need to run the queue worker:

```bash
php artisan queue:work
```

For production environments, it's recommended to use a process manager like Supervisor to keep the queue worker running.

## Troubleshooting
If you encounter any issues with the queue system, check the Laravel logs for more information:

```bash
tail -f storage/logs/laravel.log
```
