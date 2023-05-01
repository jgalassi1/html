import cx_Oracle

# Set up a connection to the database
dsn_tns = cx_Oracle.makedsn('http://3.210.165.177/', '1521', service_name='ORCLCDB')
conn = cx_Oracle.connect(user='timmy', password='timmy', dsn=dsn_tns)

# Create a cursor object
cur = conn.cursor()

# Execute a SQL query
cur.execute('SELECT * FROM workout')

# Fetch the results
results = cur.fetchall()

# Print the results
for row in results:
    print(row)

# Close the cursor and connection
cur.close()
conn.close()
