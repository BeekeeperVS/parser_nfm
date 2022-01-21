FROM node:13

RUN #apk add --update --no-cache udev ttf-freefont chromium

WORKDIR /app
COPY ./api_parser/ /app
RUN npm install

ENV PUPPETEER_SKIP_CHROMIUM_DOWNLOAD="true" \
    PUPPETEER_EXECUTABLE_PATH="/usr/bin/chromium-browser"

CMD ["npm", "run", "start"]