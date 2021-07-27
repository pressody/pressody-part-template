# PixelgradeLT Part Template

Starter WP plugin template for the code attached to LT Parts (companion LT Part plugin).

## About

Use this as your starting point for coding the integration of an LT Part (managed by LT Records).

## Developing a new PixelgradeLT Part plugin

If you know what you are doing you can go any number of ways towards developing a companion LT Part plugin, even ignoring this template and starting fresh. But lets tackle the case when you want to stick to this template.

This template's intention is to **speed up development and make it more error-proof.** By providing **a set of patterns** (like Dependency Injection, Loggers and Log Handlers, etc.), this template ensures you can easily and confidently bolt things together and have your logic behave predictably.

### Step 1 - Create a new GitHub repo

Each LT Part companion plugin should reside in **a separate Git repo,** most likely hosted on GitHub.com. 

**The hard way** would be to:
- create a new, empty GitHub repo yourself
- open a terminal window into your development directory
- clone _this_ repo locally by running `git clone --depth 1 https://github.com/pixelgradelt/pixelgradelt-part-template your-part-slug` (replace `your-part-slug` with the actual slug you intend to use)
- `cd` into the newly created directory (`your-part-slug`)
- change the remote URL to your new, empty GitHub repo by running `git remote set-url origin https://github.com/USERNAME/REPOSITORY.git` and verify the change with `git remote -v`
- finally, push your "changes" to the GitHub repo by running `git push origin`.

**The easy way** is to take advantage of the fact that **this GitHub repo is made available as a template** for creating other repos. So simply click the "Use this template" button and follow the instructions.

![Use this repo as a template for a new GitHub repo](docs/images/use-as-template.png)

After that, clone the new GitHub repo locally for development by running `git clone https://github.com/USERNAME/REPOSITORY.git your-part-slug`.

Now you can start setting up your LT Part companion plugin, clean-up, and develop the specific logic.

### Step 2 - Set up your PixelgradeLT Part plugin



## Development

### Building a new release

Since this is ultimately a WordPress plugin, you wil need to **generate a cleaned-up .zip file when you wish to publish a new release.**

To generate a new release ZIP file you have the utility script `bin/archive`. You can run it as such, without any arguments, or you can provide a version like so `bin/archive --version=1.0.2`. If you don't provide a version, the release version will be fetched from the plugin's main file headers.

Once the version has been deduced, **the script will enforce it** in the plugin's main .php file and in the `package.json` file. This way everything is kept in sync.

For the `bin/archive` script there are a couple of **things that are important:**
* the `name` entry in `package.json` is **the same** as the plugin main file (minus the `.php` extension)
* **the files and directories that will be included** in the release file need to be explicitly specified in the `distFiles` entry in `package.json`

The `bin/archive` script will also generate a fresh `.pot` language file in the `languages` directory, before creating the release file. This way you can be sure that the `.pot` file is not out-of-sync.

**The resulting release file will be located in the `dist` directory,** in your plugin directory (it is ignored by Git).

### Running Tests

To run the PHPUnit tests, in the root directory of the plugin, run something like:

```
./vendor/bin/phpunit --testsuite=Unit --colors=always
```
or
```
composer run tests
```

Bear in mind that there are **simple unit tests** (hence the `--testsuite=Unit` parameter) that are very fast to run, and there are **integration tests** (`--testsuite=Integration`) that need to load the entire WordPress codebase, recreate the db, etc. Choose which ones you want to run depending on what you are after.

You can run either the unit tests or the integration tests with the following commands:

```
composer run tests-unit
```
or
```
composer run tests-integration
```

**Important:** Before you can run the tests, you need to create a `.env` file in `tests/phpunit/` with the necessary data. You can copy the already existing `.env.example` file. Further instructions are in the `.env.example` file.

## Credits

...
