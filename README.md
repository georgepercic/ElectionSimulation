# Romanian Election Simulation System

## Overview
This is a Domain-Driven Design (DDD) application simulating the Romanian election process, built using PHP 8.4.

## Key Features
- Comprehensive vote validation
- State machine for vote status
- RabbitMQ integration for vote submission
- External API interaction with Central Election Bureau (BEC)
- SOLID principles implementation

## Project Structure
- `src/Domain/`: Core domain logic
- `src/Infrastructure/`: External integrations
- `src/Application/`: Application services and DTOs

## Requirements
- PHP 8.4
- Composer
- RabbitMQ
- Doctrine ORM

## Setup
1. Clone the repository
2. Run `composer install`
3. Configure database and message queue settings
4. Run migrations
5. Configure external BEC API endpoint

## Running Tests
```bash
./vendor/bin/phpunit
```

## Validation Rules
1. Voting hours: 7:00 AM - 9:00 PM
2. One vote per voter
3. Valid voter ID required
4. Candidate must be BEC approved
5. Proper ballot marking
6. No external interference

## Design Principles
- Domain-Driven Design
- SOLID Principles
- Clean Code Practices