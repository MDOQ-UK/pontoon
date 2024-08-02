# pontoon

## Description
This is a simplisitc implementation of the game [Pontoon](https://en.wikipedia.org/wiki/Pontoon_(banking_game))

It is designed as you vs the dealer.
All you have to do is beat the dealers score to win the game.

## Installation
**N.B** we would recommend opening this repo in Github codespaces, as all dependencies will be availble.

### Codespaces
1. You will need to edit this file: `/usr/local/php/8.2.13/ini/conf.d/xdebug.ini`, just add a ';' at the start of each line.
2. run `composer install`
3. Test you can run `./pontoon play`


## Usage
You can run the game with the command 
```bash
./pontoon play
```

You can list the available commands with
```bash
./pontoon
```

## Tasks
The following activities have been identified as required.

1. Help and description text.
    - [ ] The command description (what you see when you run `./pontoon`) should be changed to "Play Pontoon".
    - [ ] The command help text (what you see when you run `./pontoon play --help`) should be change to "no arguments needed".

2. Display hand
    - [ ] the `displayHand` function in `src/Command/Play.php` should display the users hand nicely.

3. Share the deck
    At the moment the player and the dealer use their own decks. 
    - [ ] Update the code so that they share the same deck, this will stop the same cards being used.

4. Limit draw
    At the moment the `Deck` class will just keep drawing cards even if there are non left. 
    - [ ] update the `Deck` class method `draw` so that it throws an `\Exception` if there are no cards left.
    You can test this by running `./vendor/bin/phpunit tests --filter DeckTest`

5. Best score logic
    At the moment the `getScore` method of the `Pontoon` class just returns the first score.
    - [ ] update the `Pontoon` class method `getScore` so that it returns the highest score that is less than or equal to 21.