# todo-api-php

## Todo List
- [ ] Create todos from an HTTP call
- [ ] Send and email when a todo item has been marked as done (use `symfony/mailer` and MailCatcher)
- [ ] Create todos in async
- [ ] Add check list for each todo
- [ ] Create daily reports (Total created, total pending, total done...)
- [ ] Send push notifications when a todo item has been marked as done (use `symfony/mercure-bundle` and Mercure.rocks)

## Useful Commands
- `php bin/console debug:messenger` -> Check Messenger setup
- `php bin/console doctrine:database:create --env=test` -> Create test DB

## Resources
- [Symfony Docker](https://github.com/dunglas/symfony-docker)
- [Event Bus](https://karoldabrowski.com/blog/event-bus-in-symfony-application/)
- [xDebug Setup](https://github.com/dunglas/symfony-docker/blob/main/docs/xdebug.md)
