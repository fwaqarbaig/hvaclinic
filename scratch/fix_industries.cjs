const fs = require('fs');

let code = fs.readFileSync('storage/industries_array.cjs', 'utf8');
const dummyVars = 'const a="icon", b="icon", c="icon", d="icon", e="icon", f="icon", g="icon", h="icon", i="icon", j="icon", k="icon", l="icon", m="icon", n="icon", o="icon", p="icon", q="icon", r="icon", s="icon", t="icon", u="icon", v="icon", w="icon", x="icon", y="icon", z="icon";\n';

fs.writeFileSync('storage/industries_array.cjs', dummyVars + code);
try {
    const data = require('../storage/industries_array.cjs');
    fs.writeFileSync('storage/industries.json', JSON.stringify(data, null, 2));
    console.log('Industries extracted successfully! Total:', data.length);
} catch (e) {
    console.error('Error:', e.message);
}
