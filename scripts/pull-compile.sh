GREEN='\033[1;32m'
NC='\033[0m' # No Color

git reset --hard && \
git pull && \
php artisan migrate && \
composer install && \
npm install && \
rm -rf public/js && \
npm run prod && \
printf "${GREEN}###################################!${NC}\n"
printf "${GREEN}Pull and Compile Completed!${NC}\n"
printf "${GREEN}###################################!${NC}\n"