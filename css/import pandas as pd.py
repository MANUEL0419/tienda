import pandas as pd
import numpy as np

'''data=[[1,'a',100], [2,'b',200], [3,'c',300]]
columnas=['ID','letra','valor']
df=pd.DataFrame(data, columns=columnas)
print (df)

mi_serie =pd.Series([1,2,3,4])
print (mi_serie)

array =np.array([10,20,30,40,50])
mi_serie =pd.Series(array)
print(mi_serie)

diccionario={'a':1,'b':2,'c':3}
mi_serie=pd.Series(diccionario)
print(mi_serie)'''

df = pd.read_excel('archivo_tema_2.xlsx', sheet_name='Hoja1')
print (df.head())

print ('forma del data frame: ',df.shape)