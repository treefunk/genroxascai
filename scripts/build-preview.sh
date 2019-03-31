GREEN='\033[1;32m'
NC='\033[0m' # No Color

rm -rf public/js && \
npm run prod && \
printf "${GREEN}Build Complete! Please run sync!${NC}\n"