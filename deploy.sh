#!/Bin/bash
rsync -av ./ ssh_jakpaa1411@jakpaa.com:~/ --include=public/.htaccess --exclude-from=.gitignore --exclude=".*"