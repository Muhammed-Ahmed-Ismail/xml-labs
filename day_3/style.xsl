<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
  <xsl:template match="/">
  <html>

<body>
<h1> Contacts</h1>
<table border="1">
  <thead>
<tr>
<th> Name</th>
<th>Phones</th>
<th>Adresees</th>
<th>Email</th>
</tr>
  </thead>
  <tbody>

  <xsl:for-each select="contacts/employee">
<tr>
  <td rowspan="3"><xsl:value-of select="name"/></td>
  <td> <xsl:value-of select="phones/phone[1]"/></td>
  <td> <xsl:value-of select="adresses/address[1]"/></td>
  <td rowspan="3"> <xsl:value-of select="email"/></td>
</tr>
    <tr>
      <td> <xsl:value-of select="phones/phone[2]"/></td>
      <td> <xsl:value-of select="adresses/address[2]"/></td>
    </tr>
    <tr>
      <td> <xsl:value-of select="phones/phone[3]"/></td>
      <td> <xsl:value-of select="adresses/address[3]"/></td>
    </tr>
  </xsl:for-each>
  </tbody>
</table>

</body>  
  </html>
  </xsl:template>
</xsl:stylesheet>
