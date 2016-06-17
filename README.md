# Pinboard

Adds a pinboard to Contao. Here visitors or logged in members can write and comment rich articles (image, youtube videos, ...).

- [Pinboard module configuration](docs/pinboard.png)
- [Pinboard editor module configuration](docs/editor.png)
- [Pinboard reader module configuration](docs/reader.png)

## Features

- pinboard module with masonry support
- pins are modelled as tl_news instances of type _pinboard_ -> no custom entity needed
- pins can contain text and media (images, youtube)
- reader module with contao comment support

### Modules

Name | Description
---- | -----------
ModulePinBoard | The module showing all pins in a masonry list
ModulePinBoardEditor | The module for editing pins
ModulePinBoardReader | A reader showing a single pin