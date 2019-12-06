from os.path import dirname, abspath

def init(params):
    archivo = open("%s/input.txt" % dirname(abspath(__file__))).readlines()

    lista = [int(x) for x in archivo[0].split(",")]
    lista[1] = params["noun"]
    lista[2] = params["verb"]
    return lista

def sumar(lista, posicion1, posicion2, salida):
    n1, n2 = lista[posicion1], lista[posicion2]
    lista[salida] = n1 + n2
    return lista

def multiplicar(lista, posicion1, posicion2, salida):
    n1, n2 = lista[posicion1], lista[posicion2]
    lista[salida] = n1 * n2
    return lista

def procesar(m, point):
    opcion = m[point]
    if opcion == 99:
        return m[0]
    if opcion == 1:
        m = sumar(m, m[point +1], m[point + 2], m[point + 3])
    elif opcion == 2:
        m = multiplicar(m, m[point +1], m[point + 2], m[point + 3])
    point += 4
    return procesar(m, point)

for noun in range(99):
    for verb in range(99):
        result = procesar(init({ "noun": noun, "verb": verb }), 0)
        if result == 19690720:
            print({ "noun": noun, "verb": verb })
            print(100 * noun + verb)
            exit()

