const fs = require('fs')
let massArray = fs.readFileSync(`${__dirname}/input.txt`).toString().split('\n').map(v => +v).filter(v => { if (v > 0) return v; });

/**
 * Basado en el video de https://www.youtube.com/watch?v=-T_Cij_9JEs
 */
const fuel = m => {
    let f = ~~(m / 3) - 2
    if (f < 0) return 0
    return f + fuel(f)
}

console.log(
    massArray.map(mass => fuel(mass)).reduce((a, b) => a + b, 0)
)

/**
 * Mi solucion
    const fuel = m => Number.parseInt(m / 3) - 2
    const sum = s => s.reduce((a, b) => a + b, 0)
    const fuelAdd = m => {
        m = [fuel(m)]
        while (m[0] > 5) {
            m.unshift(fuel(m[0]))
        }
        return sum(m)
    }

    let result = massArray.map((m) => fuelAdd(m))

    console.log(sum(result))
*/