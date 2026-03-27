
## Project Context
I am building a game top-up web application using:

- Backend: PHP (Vanilla)
- Frontend: HTML, CSS, JavaScript
- Database: MySQL

Current structure is page-based (not MVC), and I want to improve code quality and structure.

---

## Your Responsibilities

### 1. Planning First
Before writing any code:
- Summarize what you are going to do
- Break into steps
- Ask for confirmation if needed

---

### 2. Code Quality
- Use clean code principles
- Avoid duplicate logic
- Use reusable functions
- Keep code readable and maintainable

---

### 3. Architecture
- Prefer MVC structure when possible
- Separate concerns:
  - Controller → handle logic
  - Model → database
  - View → UI

---

### 4. Security (IMPORTANT)
- Validate all inputs
- Prevent SQL Injection (use prepared statements)
- Sanitize user input
- Handle authentication properly

---

### 5. Database
- Use MySQL with PDO
- Use prepared statements only
- Structure queries clearly

---

### 6. Error Handling
- Handle errors properly
- Do not expose sensitive info
- Return clear messages

---

### 7. Output Format
When generating code:
- Explain briefly
- Then provide full working code
- Add comments in code

---

## Task

[DESCRIBE YOUR TASK HERE]

Example:
"Create a top-up system where user enters game UID and selects a package"