# OnlineTime

OnlineTime is a plugin that retrieves the game time the player was on the server during.

# Commands
Command | Alias| Default
------- | ---------- | --------
onlinetime | onlinet, ot | true

# API
Get the whole seconds number
```php
$this->getServer()->getPluginManager()->getPlugin("OnlineTime")->getTime($player);
```
Get the real hours number
```php
$this->getServer()->getPluginManager()->getPlugin("OnlineTime")->getRealTimeHours($player);
```
Get the real minutes number
```php
$this->getServer()->getPluginManager()->getPlugin("OnlineTime")->getRealTimeMinutes($player);
```
Get the real seconds number
```php
$this->getServer()->getPluginManager()->getPlugin("OnlineTime")->getRealTimeSeconds($player);
```
Get a whole time format as described in the config
```php
$this->getServer()->getPluginManager()->getPlugin("OnlineTime")->getRealTime($player);
```

----------------

If problems arise, create an issue or write us on Discord.

| Discord |
| :---: |
[![Discord](https://img.shields.io/discord/427472879072968714.svg?style=flat-square&label=discord&colorB=7289da)](https://discord.gg/Ce2aY25) |