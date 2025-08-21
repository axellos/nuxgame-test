# NuxGame Test Task

## Setup Instructions

1. **Clone the project**
   ```bash
   git clone git@github.com:axellos/nuxgame-test.git
   cd nuxgame-test
2. **Start Docker containers**
    ```bash
   docker compose up -d
3. **Enter the PHP container**
    ```bash
   docker compose exec php sh
4. **Initialize the project**
    ```bash
   make init
5. Done! The project is ready to use.

## Running Tests

**From inside the PHP container, run:**
```bash
make test
