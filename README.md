# Joomla plugin plg_system_insertwhatwhereghsvs

Insert whatever before/after specific HTML tags like HEAD, BODY...

If you use relative paths in href or src, e.g. when you insert `<link href="templates/bimbam/css/myoverrides.css" rel="stylesheet" />` take care that plugin "System - SEF" runs after this plugin (see image 3 below). You can reorder them in Joomla by Drag&Drop.

-----

![alt ""](https://github.com/GHSVS-de/plg_system_insertwhatwhereghsvs/blob/master/15-09-_2020_18-29-39.jpg?raw=true)

-----

![alt ""](https://github.com/GHSVS-de/plg_system_insertwhatwhereghsvs/blob/master/16-09-_2020_11-59-13.jpg?raw=true)

-----

![alt ""](https://github.com/GHSVS-de/plg_system_insertwhatwhereghsvs/blob/master/16-09-_2020_12-19-37.jpg?raw=true)

----------------
# My personal build procedure (WSL 1, Debian, Win 10)
- Prepare/adapt `./package.json`.
- `cd /mnt/z/git-kram/plg_system_insertwhatwhereghsvs`

## node/npm installation
- `npm install` (if never done yet)
### node/npm updates
- `npm run updateCheck` or (faster) `npm outdated`
- `npm run update` (if needed) or (faster) `npm update --save-dev`
- `npm install` (if needed)

## Build installable ZIP package
- `node build.js`
- New, installable ZIP is in `./dist` afterwards.
- All packed files for this ZIP can be seen in `./package`. **But only if you disable deletion of this folder at the end of `build.js`**.

### For Joomla update and changelog server
- Create new release with new tag.
- - See and copy and complete release description in `dist/release.txt`.
- Extracts(!) of the update and changelog XML for update and changelog servers are in `./dist` as well. Copy/paste and make necessary additions.
