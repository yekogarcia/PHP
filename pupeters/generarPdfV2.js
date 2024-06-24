
//const puppeteer = require('/var/www/sit/branches/sit-ecocarga/node_modules/puppeteer')

//const puppeteer = require('/home/enderg/node_modules/puppeteer')
// const puppeteer = require('/home/manager/node_modules/puppeteer')
const puppeteer = require('/home/yeko/workspace/pupeters/node_modules/puppeteer');

var arg = process.argv.slice(2)
console.log(arg);
if (typeof arg[0] == 'undefined') {
        console.log("\n");
        console.log("Debe agregar el parámetro de usuario (node generarPdf.js andresf) ");
        return false;
}




var convertirV2 = function () {
        let options = { format: 'A4' };
        let url = arg[3];
        url += "/printer.php?source=";
        url += arg[4];
        url += "&id=";
        url += arg[5];
        url += "&id_usuario=";
        url += arg[6];
        let add = "&usuario=";
        add += arg[0];
        add += "&empresa=";
        add += arg[1];
        url += add;
        console.log("URL:" + url);
        let file = { url: url };
        (async () => {
                const browser = await puppeteer.launch({ headless: true, args: ['--use-gl=egl'] });
                //        const browser = await puppeteer.launch({headless: true, args: ['--use-gl=egl','--no-sandbox', '--disable-setuid-sandbox']});
                const page = await browser.newPage();
                await page.setDefaultNavigationTimeout(0);
                await page.goto(url, { waitUntil: 'networkidle0' });
                const pdf = await page.pdf({ format: 'A4' });
                await page.addStyleTag({ content: 'h4 { BACKGROUND-COLOR:  #016f90} ' });
                await page.pdf({
                        printBackground: true,
                        path: arg[2],
                        format: "Letter",
                        margin: {
                                top: "20px",
                                bottom: "40px",
                                left: "20px",
                                right: "20px"
                        }
                });
                await browser.close();
        })()

}

convertirV2();