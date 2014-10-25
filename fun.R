
ticks = dir("stocks")
ticks = unlist(lapply(ticks,function(x) { # strip extension
  return(unlist(strsplit(x,".dat")))
}))
nms = c()
for (i in 1:length(ticks)) { # create new columnar data frame with stock prices
  vals = read.csv(paste("stocks/",ticks[i],".dat",sep=""))
  if (dim(vals)[1]==502) { # only with those with all data across 2 years
    if (i==1) {
      closes = data.frame(rev(vals$Adj.Close))
    } else {
      closes = cbind(closes,rev(vals$Adj.Close))
    } 
    nms = c(nms,ticks[i])
    print(ticks[i])
  }
}
colnames(closes) = nms # name the columns with those that had enough data
plot(closes$AAPL,type='l') # Apple!




