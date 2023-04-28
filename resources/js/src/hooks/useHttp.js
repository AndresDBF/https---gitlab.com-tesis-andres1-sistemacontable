import { useState, useEffect } from "react";

export const useHttp = (url) => {
  const [data, setData] = useState(null);

  useEffect( async () => {
    let response = await fetch(url);
    setData(await response.json() );
  }, [url]);

  return [data];
};