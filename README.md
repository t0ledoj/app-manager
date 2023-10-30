# Cloud++ Test

### Description:
The test consists of a CRUD for projects.

### Prerequisites:
- Installed and running Docker
- All containers running on the machine should be stopped
- If there is an Apache server running, it should be stopped to avoid conflicts with Docker

### Installation:
```bash
# Clone the project from this repository
$ git clone https://github.com/t0ledoj/app-manager.git

# Access the project folder
$ cd app-manager

# Install the project
$ docker run --rm --interactive --tty --volume $PWD:/app composer install

# Rename the .env.example file
$ mv .env.example .env

# Build the project
$ vendor/bin/sail build

# Run Docker (sail)
$ vendor/bin/sail up
```
In another terminal tab, execute:
```bash
# Generate the encrypted key for the project
$ vendor/bin/sail artisan key:generate

# Apply configurations from the .env file
$ vendor/bin/sail artisan config:cache

# Create tables in the database
$ vendor/bin/sail artisan migrate

# Populate tables in the database
$ vendor/bin/sail artisan db:seed

# Install node dependencies
$ vendor/bin/sail npm install

# To run the node server
$ vendor/bin/sail npm run dev
```

Keep the terminal open during execution. To stop the execution, use `Ctrl + C`  keys.

### Execution:
For each new execution, the following command should be used within the project folder:

```bash
 $ vendor/bin/sail up
```

### Access:
The application can be accessed at http://localhost/